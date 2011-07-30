<?php echo $html->css('posts'); ?>


<div class=posts><!-- used as main positioning for posts block -->
<?php 

	if ($this->Session->check('Auth.User'))
		{
			echo $this->Html->link('Admin Control Panel', array('controller' => 'posts', 'action' => 'controls'), array('class' => 'button', 'target' => '_blank')); 
			echo '<div class="post-admin">';
			echo $this->Html->link($this->Html->image("icons/film_delete.png", array('alt' => 'Delete This Post')), array('controller' => 'posts', 'action' => 'delete', $data['Post']['id']), array('escape' => false));
			echo '</div>';
		}
		$this->Post->admin($data);
		
	$this->Post->show($data);

// echo comments & shit

?>	
</div>