<?php
App::uses('TwitterApi', 'Twitter.Model');
class TwitterStatuses extends TwitterApi {

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_request['uri']['path'] .= '/statuses';
	}
	
	/**
	 * https://dev.twitter.com/docs/api/1.1/get/statuses/home_timeline
	 */
	public function homeTimeline($options = null) {
		$request = array();
		$request['uri']['query'] = $options;
		return $this->_request('/home_timeline', $request);
	}

	/**
	 * https://dev.twitter.com/docs/api/1.1/get/statuses/mentions_timeline
	 **/
	public function mentionsTimeline($options = null) {
		$request = array();
		$request['uri']['query'] = $options;
		return $this->_request('/mentions_timeline', $request);
	}

	/**
	 * https://dev.twitter.com/docs/api/1.1/get/statuses/retweets_of_me
	 **/
	public function retweetsOfMe($options = null) {
		$request = array();
		$request['uri']['query'] = $options;
		return $this->_request('/retweets_of_me', $request);
	}

	/**
	 * https://dev.twitter.com/docs/api/1.1/get/statuses/show/%3Aid
	 **/
	public function show($id, $options = null) {
		$request = array();
		$request['uri']['query'] = $options;
		return $this->_request(sprintf('/show/%s', $id), $request);
	}

	/**
	 * https://dev.twitter.com/docs/api/1.1/post/statuses/update
	 **/
	public function update($status, $options = null) {
		$request = array();
		$request['method'] = 'POST';
		$request['uri']['query'] = $options;
		$request['uri']['query']['status'] = $status;
		return $this->_request('/update', $request);
	}

	/**
	 * https://dev.twitter.com/docs/api/1.1/get/statuses/user_timeline
	 **/
	public function userTimeline($options = null) {
		$request = array();
		$request['uri']['query'] = $options;
		return $this->_request('/user_timeline', $request);
	}
}
