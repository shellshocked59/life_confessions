<?php
/* PostsPhoto Fixture generated on: 2011-07-16 12:17:28 : 1310818648 */
class PostsPhotoFixture extends CakeTestFixture {
	var $name = 'PostsPhoto';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'post_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'caption' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'offset' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'image_1280' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'image_500' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'image_400' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'image_250' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'image_100' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'image_75' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'post_id' => 1,
			'caption' => 1,
			'offset' => 1,
			'image_1280' => 'Lorem ipsum dolor sit amet',
			'image_500' => 'Lorem ipsum dolor sit amet',
			'image_400' => 'Lorem ipsum dolor sit amet',
			'image_250' => 'Lorem ipsum dolor sit amet',
			'image_100' => 'Lorem ipsum dolor sit amet',
			'image_75' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-07-16 12:17:28',
			'modified' => '2011-07-16 12:17:28'
		),
	);
}
