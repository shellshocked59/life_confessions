<?php
	echo $this->Html->link('Get All', array('controller' => 'posts', 'action' => 'getBatchTumblr', 'life-confessions', 'all'), array('class' => 'button', 'target' => '_blank')); 
	echo '<br />';
	echo $this->Html->link('Get Last 60', array('controller' => 'posts', 'action' => 'getBatchTumblr', 'life-confessions', '60'), array('class' => 'button', 'target' => '_blank')); 
	echo '<br />';
	echo $this->Html->link('Delete All', array('controller' => 'posts', 'action' => 'deleteAll', '0'), array('class' => 'button', 'target' => '_blank')); 
	echo '<br />';
	echo $this->Html->link('Register Blog', array('controller' => 'blogs', 'action' => 'add'), array('class' => 'button', 'target' => '_blank')); 
	echo '<br />';
	echo $this->Html->link('View Blogs', array('controller' => 'blogs', 'action' => 'index'), array('class' => 'button', 'target' => '_blank')); 
	
?>
