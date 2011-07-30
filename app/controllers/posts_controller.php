<?php
class PostsController extends AppController {

	var $name = 'Posts';
	var $paginate = array(
        'limit' => 10,
        'order' => array(
            'Post.created' => 'desc'
        )
    );
	var $helpers = array('Post');
	
	function beforeFilter() 
	{
		parent::beforeFilter();
		$this->Auth->allowedActions = array('index');
	}
	function index($condition = 'all', $query = '')
	{
		//search through all posts
		//paginate through all posts
		//show by type in a view helper
		//handles the search box
		
		if (isset($this->data)) 
		{
			$query = $this->data['Search']['search'];
			$this->passedArgs['query'] = $query;
			$this->redirect("/posts/index/all/{$query}");

		} 
		
		// $options['order']['Post.id'] = 'desc'; //change to date
		// $options['limit'] = 20;
		// $options['conditions']['viewable'] = 1;
		
		switch($condition)
		{
			case 'all':
			break;
			case 'tag':
				$options['conditions']['Tag.name'] = $condition;	
			break;
			case 'blog':
				$options['conditions']['Post.blog'] = $condition;	
			break;
		}
		
		
		//finds posts similar to the posts in the like query
		if($query == '')
		{
			$data = $this->paginate('Post');
		}
		else
		{
			$query_wildcards = '%' . $query . '%';
			$data = $this->paginate('Post', array('OR' => array('Post.caption LIKE' => $query_wildcards,
															   'Post.content LIKE' => $query_wildcards,
															   'Post.slug LIKE' => $query_wildcards, 									   
															   //'Tag.name LIKE' => $query_wildcards,
															   // 'Post.blog LIKE' => $query_wildcards,
															   'Post.audio_title LIKE' => $query_wildcards
															  )));
		}
										 
		$this->set(compact('data', 'query'));
	}
	function delete($id) 
	{
		$cur_video = $this->Post->read(null, $id);
		$this->Post->delete($id);
	
		//$this->Session->setFlash('Post deleted!');
		$this->redirect(array('action' => 'index'));
	}
	
	function view($id)
	{   
			$this->Post->id = $id;       
			$this->set('data', $this->Post->read());    
	
	}
	function controls()
	{
		//used for admin controls
	}
	
	function deleteAll($blog_id)
	{
		$posts = $this->Post->find('all', array('recursive' => -1, 'fields' => array('Post.id'), 'conditions' => array('Post.blog_id' => $blog_id)));
		if(!empty($posts))
		{
			foreach($posts as $key=>$value)
			$this->Post->delete($value['Post']['id']);
		}
	}
	
	function getBatchTumblr ($url = 'life-confessions', $total = '100') 
	{
		
		set_time_limit(0);
		$this->render = ('index');
		
		$json = $this->getTumblr($url, $param = 'num=1');
		if ($total == 'all')
		{
			$total = $json['posts-total'];
		}
		$i = 0;
		while ($i < $total)
		{
			$num = 20;
			$param = 'num='.$num.'&start='.$i;
			$json = $this->getTumblr($url, $param);
			$this->parseTumblr($json);
			$i = ($i + $num);
		}
	}
	private function getTumblr($url, $param = 'num=50')
	{
		$url = 'http://'.$url.'.tumblr.com/api/read/json?'.$param;

		$ci = curl_init($url);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		$input = curl_exec($ci);

		// Tumblr JSON doesn't come in standard form, some str replace needed
		$input = str_replace('var tumblr_api_read = ','',$input);
		$input = str_replace(';','',$input);
		// parameter 'true' is necessary for output as PHP array
		$json = json_decode($input, true);
		return $json;

	}
	
	private function parseTumblr($json)
	{
		$name = $json['tumblelog']['name'];
		$existing_blog_id = $this->Post->query("SELECT DISTINCT `id` FROM `blogs` WHERE `name` = '".$name."'");
		
		if(empty($existing_blog_id))
		{
			echo 'Register the blog you wish to pull from before pulling data from it'; exit;
		}

		foreach($json['posts']	as $key => $value)
		{ 
			$post = null;
			$post_photos = null;
			$conversations = null;
			$tags = null;
			$post = $this->standardGetTumblr($value);
			$tags = $this->getTumblrTags($value);
			
			
			$post['blog'] = $name;
			
			
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
					/*
					$content = file_get_contents($post['photo-url-1280']);
					file_put_contents('img/post_photos/'.$post['title'].'.jpg', $content);
					*/
				}
				if(!empty($value['photos']))
				{
					foreach ($value['photos'] as $key2 => $value2)
					{
						//$post_photos[$key2]['post_id'] = $post['tumblr_id'];
						
						if (!empty($value2['width']))
						{
							$post_photos[$key2]['width'] = $value2['width'];
						}
						if (!empty($value2['height']))
						{
							$post_photos[$key2]['height'] = $value2['height'];
						}
						if (!empty($value2['photo-url-1280']))
						{
							$post_photos[$key2]['image_1280'] = $value2['photo-url-1280'];
						}
						if (!empty($value2['photo-url-500']))
						{
							$post_photos[$key2]['image_500'] = $value2['photo-url-500'];
						}
						if (!empty($value2['photo-url-400']))
						{
							$post_photos[$key2]['image_400'] = $value2['photo-url-400'];
						}
						if (!empty($value2['photo-url-250']))
						{
							$post_photos[$key2]['image_250'] = $value2['photo-url-250'];
						}
						if (!empty($value2['photo-url-100']))
						{
							$post_photos[$key2]['image_100'] = $value2['photo-url-100'];
						}
						if (!empty($value2['photo-url-75']))
						{
							$post_photos[$key2]['image_75'] = $value2['photo-url-75'];
						}
						if (!empty($value2['caption']))
						{
							$post_photos[$key2]['caption'] = $value2['caption'];
						}
						if (!empty($value2['offset']))
						{
							$post_photos[$key2]['offset'] = $value2['offset'];
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
					$post['title'] = $value['question'];				
				}
				if (!empty($value['answer']))
				{
					//question asked
					$post['content'] = $value['answer'];					
				}
			break;
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
						
						$conversations[$key2]['number'] = $key2;
						$conversations[$key2]['post_id'] = $post['tumblr_id'];
						if (!empty($value2['name']))
						{
							$conversations[$key2]['name'] = ($value2['name']);
						}
						if (!empty($value2['label']))
						{
							$conversations[$key2]['label'] = ($value2['label']);
						}
						if (!empty($value2['phrase']))
						{
							$conversations[$key2]['phrase'] = ($value2['phrase']);
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
			
			/*
			//START debugging
			echo 'DATABASE POST<br />';
			debug($post);
			if (!empty($tags))
			{
				echo 'DATABASE TAG<br />';
				debug($tags);
			}
			if (!empty($post_photos))
			{
				echo 'DATABASE PHOTO SET<br />';
				debug($post_photos);
			}
			if (!empty($conversations))
			{
				echo 'DATABASE CONVERSATION<br />';
				debug($conversations);
			}
			echo 'TUMBLR JSON<br />';
			debug($value);
			//END debugging
			*/
			$this->saveTumblr($post, $tags, $post_photos, $conversations);
		}
		return;
		//END OF FOREACH
	}
	


	private function getTumblrTags($post)
	{
		if (!empty($post['tags']))
		{
			foreach($post['tags'] as $key => $value)
			{
				//$tags['post_id'] = $post['id'];
				$tags[$key]['name'] = $value;
			}
			return $tags;
		}
	}
	private function standardGetTumblr($value)
	{
		//post id
		$post['tumblr_id'] = $value['id'];
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
	
	
	private function saveTumblr($post, $tags = null, $post_photos = null, $conversations = null)
	{
		$data['Post'] = $post;
		
		if (!empty($conversations))
		{
			$data['PostConversation'] = $conversations;
		}
		if (!empty($post_photos))
		{
			$data['PostPhoto'] = $post_photos;
		}
		
		if (!empty($tags))
		{
			$data['PostTag'] = $tags;
		}
		
		// $selectID = "SELECT `id` FROM `tags` WHERE `name` = '".$tag['name']."'";
		// $insert = "INSERT INTO `tags` (`name`) VALUES ('".$tag['name']."')";
		
		// echo($selectID);
		
		// mysql_query('TRUNCATE TABLE `posts`');
		// mysql_query('TRUNCATE TABLE `posts_tags`');
		// exit;
		$existing_post_id = $this->Post->find('first', array('recursive' => -1, 'fields' => array('Post.id'), 'conditions' => array('Post.tumblr_id' => $data['Post']['tumblr_id'])));
		if(!empty($existing_post_id['Post']['id']))
		{
			$this->Post->delete($existing_post_id['Post']['id']);
		}
		$data['Post']['id'] = $existing_post_id['Post']['id'];
		if ($this->Post->saveall($data))
		{
			//success of save
		}
		else
		{
			echo 'an error has occured'; exit;
		}			
	}
	
}
