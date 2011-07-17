<?php
/* Tag Test cases generated on: 2011-07-16 12:11:54 : 1310818314*/
App::import('Model', 'Tag');

class TagTestCase extends CakeTestCase {
	var $fixtures = array('app.tag', 'app.post', 'app.tags_post');

	function startTest() {
		$this->Tag =& ClassRegistry::init('Tag');
	}

	function endTest() {
		unset($this->Tag);
		ClassRegistry::flush();
	}

}
