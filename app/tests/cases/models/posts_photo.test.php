<?php
/* PostsPhoto Test cases generated on: 2011-07-16 12:17:28 : 1310818648*/
App::import('Model', 'PostsPhoto');

class PostsPhotoTestCase extends CakeTestCase {
	var $fixtures = array('app.posts_photo', 'app.post');

	function startTest() {
		$this->PostsPhoto =& ClassRegistry::init('PostsPhoto');
	}

	function endTest() {
		unset($this->PostsPhoto);
		ClassRegistry::flush();
	}

}
