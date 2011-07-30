<?php
class BlogsController extends AppController {

	var $name = 'Blogs';

	var $helpers = array('Post');
	
	function beforeFilter() 
	{
		parent::beforeFilter();
		$this->Auth->allowedActions = array();
	}
	function index()
	{
		
	}
	function add()
	{
		
	}
	function edit()
	{
		
	}
	function delete()
	{
		
	}
	