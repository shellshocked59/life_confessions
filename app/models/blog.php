<?php
class Blog extends AppModel {
	var $name = 'Blog';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $validate = array(
		'name' => array(
		'rule' => 'isUnique',
		'message' => 'blog already exists.'
		)
    );

	var $hasMany = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'blog_id',
			'dependent' => true			
		)
	);

}
?>
