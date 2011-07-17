<?php
/* PostsConversation Fixture generated on: 2011-07-16 12:16:56 : 1310818616 */
class PostsConversationFixture extends CakeTestFixture {
	var $name = 'PostsConversation';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'number' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'post_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'label' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'phrase' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'number' => 1,
			'post_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'label' => 'Lorem ipsum dolor sit amet',
			'phrase' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-07-16 12:16:56',
			'modified' => '2011-07-16 12:16:56'
		),
	);
}
