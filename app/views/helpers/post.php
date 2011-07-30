<?php
class PostHelper extends AppHelper 
{  
	// var $components = array('Session');
	var $helpers = array('Form', 'Html');      
	var $value = null;
	
	function show($value)
	{
		$this->value = $value;
		$this->showHeader();
		// $this->admin();
		$this->showContent();
		$this->showFooter();
	}
	function showHeader()
	{
		echo '<div class="post-header">';
		$this->validEcho('Post', 'date');
		echo '<br />';
		echo $this->Html->link('Reblog', 'http://'.$this->value['Blog']['name'].'.tumblr.com/post/'.$this->value['Post']['url']);
		echo '</div>';
		echo '<br /><br />';
	}
	function showContent() 
    {
		echo '<div class="post-content">';
		// $this->validEcho('Post', 'id');
		// $this->validEcho('Post', 'type');
		// echo '<br /><br />';
		switch($this->value['Post']['type'])
		{
			case 'photo':
				//echo the image ??with caption as alt text??
				echo $this->Html->link(
					$this->Html->image($this->value['Post']['image_1280'], array("alt" => $this->value['Blog']['name'], "style" => "width:300px; height:250px")),
					$this->value['Post']['url'],
					array('escape' => false)
				);
			break;
			
			case 'video':
				//echo the video player
				$this->validEcho('Post', 'video_player');
			break;
			
			case 'conversation':
				//echo conversation-title
				$this->validEcho('Post', 'title');
				//echo conversation-text
				$this->validEcho('Post', 'caption');
				echo '<div class="post-conversation">';
				foreach ($this->value['PostConversation'] as $key=>$conversation)
				{
					echo '<div class="conversation-line" >';
					echo $conversation['phrase'];
					echo '</div>';
				}
				echo '</div>';
			break;
			
			case 'link':
				//echo link-text
				$this->validEcho('Post', 'content');
				echo '<br />';
				//echo link-url
				$this->validEcho('Post', 'orgin');
				echo '<br />';
				//echo link-description
				$this->validEcho('Post', 'title');
			break;
			
			case 'quote':
				//echo the quote-text
				$this->validEcho('Post', 'content');
				echo '<br />';
				//echo quote-source
				$this->validEcho('Post', 'orgin');
			break;
			
			case 'answer':
				//echo question
				$this->validEcho('Post', 'title');
				echo '<br />';
				//echo answer
				$this->validEcho('Post', 'content');
			break;
			
			case 'regular':
				//echo title
				$this->validEcho('Post', 'title');
				echo '<br />';
				//echo content
				$this->validEcho('Post', 'content');
			break;
		}
		echo '</div>';
	}
	function showFooter()
	{
		echo '<div class="post-footer">';
		//show reblog count
		echo '<span class="tags" >';
		if (!empty($this->value['PostTag']))
		{
			echo $this->showTags();
		}
		echo '</span>';
		echo '</div>';
		echo '<br /><br />';
	}
	function showTags()
	{
		echo 'Tags: ';
		foreach ($this->value['PostTag'] as $key=>$tag)
		{
			echo $this->Html->link($tag['name'],  array('controller' => 'posts', 'action' => 'index', 'tag', $tag['id'])).' ';
		}
	}
	function validEcho($array, $feild)
	{
		if(!empty($this->value[$array][$feild]))
		{
			echo $this->value[$array][$feild];
			//if string is longer than X
			//use a show more button that slides down
		}
	}
	function admin()
	{
		//if auth check
		// if ($this->Session->check('Auth.User'))
		// {
			// echo $this->Html->link($this->Html->image("icons/film_delete.png", array('alt' => 'Delete This Post')), array('controller' => 'posts', 'action' => 'delete', $this->value['Post']['id']), array('escape' => false));
		// }
	}
}