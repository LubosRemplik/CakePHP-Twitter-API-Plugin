<?php
App::uses('TwitterApi', 'Twitter.Model');
class TwitterFollowers extends TwitterApi {

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_request['uri']['path'] .= '/followers';
	}
	
	/**
	 * https://dev.twitter.com/docs/api/1.1/get/followers/ids
	 **/
	public function ids($options = null) {
		$request = array();
		$request['uri']['query'] = $options;
		return $this->_request('/ids', $request);
	}
}
