<?php
/* PostsConversation Test cases generated on: 2011-07-16 12:16:56 : 1310818616*/
App::import('Model', 'PostsConversation');

class PostsConversationTestCase extends CakeTestCase {
	var $fixtures = array('app.posts_conversation', 'app.post');

	function startTest() {
		$this->PostsConversation =& ClassRegistry::init('PostsConversation');
	}

	function endTest() {
		unset($this->PostsConversation);
		ClassRegistry::flush();
	}

}
