<?php
class Post extends AppModel {
	var $name = 'Post';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	var $hasAndBelongsToMany = array(
		/*
		'Conversation' => array(
			'className' => 'Conversation',
			'joinTable' => 'posts_conversations',
			'foreignKey' => 'post_id',
			'associationForeignKey' => 'conversation_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Photo' => array(
			'className' => 'Photo',
			'joinTable' => 'posts_photos',
			'foreignKey' => 'post_id',
			'associationForeignKey' => 'photo_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		*/
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

}
