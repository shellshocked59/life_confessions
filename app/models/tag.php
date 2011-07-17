<?php
class Tag extends AppModel {
	var $name = 'Tag';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasAndBelongsToMany = array(
		'Post' => array(
			'className' => 'Post',
			'joinTable' => 'tags_posts',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'post_id',
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
