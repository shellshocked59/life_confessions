<?php
class Post extends AppModel {
	var $name = 'Post';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	function tagsHandler($tag, $post_id)
	{
		$selectID = "SELECT `id` FROM `tags` WHERE `name` = '".$tag['name']."'";
		$insert = "INSERT INTO `tags` (`name`) VALUES ('".$tag['name']."')";
		
		debug($selectID);
		$tag_existing = $this->query($selectID);
			// $tag_existing = $this->query();
	

		if(empty($tag_existing))
		{
			$this->query("INSERT INTO `tags` (`name`) VALUES ('".$tag['name']."')");
		}
			
		$tag_id = 1;
		$this->query("INSERT INTO `tags_posts` (post_id, tag_id) VALUES ('".$post_id."', '".$tag_id."')");
	}
	function getLastQuery()
{
    $dbo = $this->getDatasource();
    $logs = $dbo->_queriesLog;

    return end($logs);
}
	
	
	
	
	
	var $validate = array(
		'tumblr_id' => array(
		'rule' => 'isUnique',
		'message' => 'post already exists.'
		)
    );
	var $belongsTo = array(
		'Blog' => array(
			'className' => 'Blog',
			'foreignKey' => 'blog_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	var $hasMany = array(
		'PostConversation' => array(
			'className' => 'PostConversation',
			'foreignKey' => 'post_id',
			'dependent' => true			
		),	
		'PostPhoto' => array(
			'className' => 'PostPhoto',
			'foreignKey' => 'post_id',
			'dependent' => true			
		),
		'PostTag' => array(
			'className' => 'PostTag',
			'foreignKey' => 'post_id',
			'dependent' => true			
		)
	);
	/*
	var $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'tags_posts',
			'foreignKey' => 'post_id',
			'associationForeignKey' => 'tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	*/

}
?>