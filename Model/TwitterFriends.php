<?php
App::uses('TwitterApi', 'Twitter.Model');
class TwitterFriends extends TwitterApi {

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_request['uri']['path'] .= '/friends';
	}
	
	/**
	 * https://dev.twitter.com/docs/api/1.1/get/friends/ids
	 **/
	public function ids($options = null) {
		$request = array();
		$request['uri']['query'] = $options;
		return $this->_request('/ids', $request);
	}
}
