<?php echo $html->css('posts'); ?>


<div class=posts><!-- used as main positioning for posts block -->
<?php
echo $this->Form->create('Search', array('url' => array('controller' => 'posts', 'action' => 'index')));
			echo $this->Form->input('search', array('div'=>false));
			if (!empty($search_type))
			{
				echo $this->Form->input( 'type', array( 'value' => $search_type  , 'type' => 'hidden', 'div'=>false));
			}
			echo $this->Form->submit('Search', array('div'=>false));  		
			echo $this->Form->end();
			
			?>


<?php 
foreach($data as $key=>$value)
{
	if ($this->Session->check('Auth.User'))
		{
			echo '<div class="post-admin">';
			echo $this->Html->link($this->Html->image("icons/film_delete.png", array('alt' => 'Delete This Post')), array('controller' => 'posts', 'action' => 'delete', $value['Post']['id']), array('escape' => false));
			echo '</div>';
		}
		$this->Post->admin($value);
		
	$this->Post->show($value);
}
// echo footer pagination controls
echo $this->element('listing_paging_footer'); 

?>	
</div>