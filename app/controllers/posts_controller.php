<?php
class PostsController extends AppController {

	var $name = 'Posts';

	function index()
	{
		//paginate through all posts
		//filter by type in a view helper
	}
	
	function add()
	{
		//use tumblr API to send a created post or message
	}
	
	function getTumblr ($url) 
	{
		$this->autoRender = false;
		$url = 'http://'.$url.'.tumblr.com/api/read/json?num=50';

		$ci = curl_init($url);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		$input = curl_exec($ci);

		// Tumblr JSON doesn't come in standard form, some str replace needed
		$input = str_replace('var tumblr_api_read = ','',$input);
		$input = str_replace(';','',$input);

		// parameter 'true' is necessary for output as PHP array
		$json = json_decode($input, true);
		// debug($json); exit;
		foreach($json['posts']	as $key => $value)
		{
			$post = $this->standardGetTumblr($value);
			$tag = $this->getTumblrTags($value);
			
			//START SWITCH
			switch ($value['type'])
			{
			//PHOTOS
			case 'photo':
				if (!empty($value['photo-caption']))
				{
					//caption for a photo
					$post['caption'] = ($value['photo-caption']);
				}
				if (!empty($value['photo-link-url']))
				{
					//photo origination link (such as person reblogged from)
					$post['orgin'] = ($value['photo-link-url']);
				}
				if (!empty($value['photo-url-1280']))
				{
					//largest size photo available. also comes in 500, 400, 250, 100, 75
					$post['image_1280'] = ($value['photo-url-1280']);
				}
				if(!empty($value['photos']))
				{
					foreach ($value['photos'] as $key2 => $value2)
					{
						$posts_photo[$key2]['post_id'] = $post['special_id'];
						
						if (!empty($value2['width']))
						{
							$posts_photo[$key2]['width'] = $value2['width'];
						}
						if (!empty($value2['height']))
						{
							$posts_photo[$key2]['height'] = $value2['height'];
						}
						if (!empty($value2['photo-url-1280']))
						{
							$posts_photo[$key2]['image_1280'] = $value2['photo-url-1280'];
						}
						if (!empty($value2['photo-url-500']))
						{
							$posts_photo[$key2]['image_500'] = $value2['photo-url-500'];
						}
						if (!empty($value2['photo-url-400']))
						{
							$posts_photo[$key2]['image_400'] = $value2['photo-url-400'];
						}
						if (!empty($value2['photo-url-250']))
						{
							$posts_photo[$key2]['image_250'] = $value2['photo-url-250'];
						}
						if (!empty($value2['photo-url-100']))
						{
							$posts_photo[$key2]['image_100'] = $value2['photo-url-100'];
						}
						if (!empty($value2['photo-url-75']))
						{
							$posts_photo[$key2]['image_75'] = $value2['photo-url-75'];
						}
						if (!empty($value2['caption']))
						{
							$posts_photo[$key2]['caption'] = $value2['caption'];
						}
						if (!empty($value2['offset']))
						{
							$posts_photo[$key2]['offset'] = $value2['offset'];
						}
					}
				}
				break;
				
			//REGULAR
			case 'regular':
				if (!empty($value['regular-title']))
				{
					//title for a regular item
					$post['title'] = ($value['regular-title']);
				}
				if (!empty($value['regular-body']))
				{
					//body for a regular item
					$post['content'] = ($value['regular-body']);
				}
				break;
			
			//QUOTE
			case 'quote':
				
				if (!empty($value['quote-text']))
				{
					//text for a quote
					$post['content'] = ($value['quote-text']);
				}
				if (!empty($value['quote-source']))
				{
					//source for a quote
					$post['orgin'] = ($value['quote-source']);
				}
				break;
			
			//LINK
			case 'link':
			
				if (!empty($value['link-text']))
				{
					//text for a link
					$post['content'] = ($value['link-text']);
				}
				if (!empty($value['link-url']))
				{
					//url for a link
					$post['orgin'] = ($value['link-url']);
				}
				if (!empty($value['link-description']))
				{
					//description for a link
					$post['title'] = ($value['link-description']);
				}
				break;
			case 'answer':
				if (!empty($value['question']))
				{
					//question asked
					$post['quote_text'] = $value['question']					
				}
				if (!empty($value['answer']))
				{
					//question asked
					$post['content'] = $value['answer']					
				}
			//CONVERSATION
			case 'conversation':
				if (!empty($value['conversation-title']))
				{
					//title for a conversation
					$post['title'] = ($value['conversation-title']);
				}
				if (!empty($value['conversation-text']))
				{
					//caption for a conversation
					$post['caption'] = ($value['conversation-text']);
				}
				foreach ($value['conversation'] as $key2 => $value2)
					{
						
						$conversation['number'] = $key2;
						$conversation['conversation_id'] = $post['special_id'];
						if (!empty($value2['name']))
						{
							$conversation['name'] = ($value2['name']);
						}
						if (!empty($value2['label']))
						{
							$conversation['label'] = ($value2['label']);
						}
						if (!empty($value2['phrase']))
						{
							$conversation['phrase'] = ($value2['phrase']);
						}
					}
				break;
				
			//VIDEO
			case 'video':
				if (!empty($value['video-caption']))
				{
					//caption for a video
					$post['caption'] = ($value['video-caption']);
				}
				if (!empty($value['video-source']))
				{
					//source href for a video
					$post['orgin'] = ($value['video-source']);
				}
				if (!empty($value['video-player']))
				{
			//player for a video, can be video-player-500 or video-player-250 instead for sizing
			$post['video_player'] = ($value['video-player']);
			}

				break;
			
			//AUDIO
			case 'audio':
				if (!empty($value['audio-caption']))
				{
					//caption for audio
					$post['caption'] = ($value['audio-caption']);
				}
				if (!empty($value['audio-source']))
				{
					//source href for audio
					$post['orgin'] = ($value['audio-source']);
				}
				if (!empty($value['video-player']))
				{
					//player for audio
					$post['video_player'] = ($value['video-player']);
				}
				if (!empty($value['audio-plays']))
				{
					//player for audio
					$post['audio_plays'] = ($value['audio-plays']);
				}
			
				//START audio metadata
				if (!empty($value['id3-artist']))
				{
					//artist for audio
					$post['audio_artist'] = ($value['id3-artist']);
				}
				if (!empty($value['id3-album']))
				{
					//album for audio
					$post['audio_album'] = ($value['id3-album']);
				}
				if (!empty($value['id3-year']))
				{
					//year for audio
					$post['audio_year'] = ($value['id3-year']);
				}
				if (!empty($value['id3-track']))
				{
					//track for audio
					$post['audio_track'] = ($value['id3-track']);
				}
				if (!empty($value['id3-title']))
				{
					//title for audio
					$post['audio_title'] = ($value['id3-title']);
				}
				//END audio metadata			
				break;
			
			//END OF SWITCH
			}
			
			//START debugging
			echo 'DATABASE POST<br />';
			debug($post);
			if (!empty($tag))
			{
				echo 'DATABASE TAG<br />';
				debug($tag);
			}
			if (!empty($posts_photo))
			{
				echo 'DATABASE PHOTO SET<br />';
				debug($posts_photo);
			}
			echo 'TUMBLR JSON<br />';
			debug($value);
			//END debugging

		}
		//END OF FOREACH
	}

	private function getTumblrTags($post)
	{
		if (!empty($post['tags']))
		{
			foreach($post['tags'] as $key => $value)
			{
				//$tag['post_id'] = $post['id'];
				$tag[$key] = $value;
			}
			return $tag;
		}
	}
	private function standardGetTumblr($value)
	{
		if (!empty($value['id']))
		{
			//post id
			$post['special_id'] = ($value['id']);
		}
		if (!empty($value['url']))
		{
			//link to see post
			$post['url'] = ($value['url']);
		}
		if (!empty($value['type']))
		{
			//type of post
			$post['type'] = ($value['type']);
		}
		if (!empty($value['date']))
		{
			//pretty date posted
			$post['date'] = ($value['date']);
		}
		if (!empty($value['unix-timestamp']))
		{
			//pretty date posted
			$post['unix_timestamp'] = ($value['unix-timestamp']);
		}
		/*
		if (!empty($value['feed-item']))
		{
			//not sure
			$post['feed_item'] = ($value['feed-item']);
		}
		*/
		if (!empty($value['reblog-key']))
		{
			//used in reblog link
			$post['reblog_key'] = ($value['reblog-key']);
		}
		if (!empty($value['slug']))
		{
			//used in reblog link
			$post['slug'] = ($value['slug']);
		}
		return $post;
	}
			
}
