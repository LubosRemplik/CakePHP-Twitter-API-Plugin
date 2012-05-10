<?php
App::uses('AppController', 'Controller');
class TwitterController extends AppController {

	public $uses = array(
		'Twitter.TwitterStatuses',
	);

	public $components = array(
		'Apis.Oauth' => 'twitter',
		'Encrypt.Decrypt'
	);

	public function connect($redirect = null) {
		$this->Oauth->connect(unserialize($this->Decrypt->hex2bin($redirect)));
	}

	public function twitter_callback() {
		Cache::clear();
		$this->Oauth->callback();
	}

	public function userTimeline($count = 5, $include_rts = true) {
		$data = $this->TwitterStatuses->userTimeline(array(
			'count' => $count,
			'include_rts' => $include_rts
		));
		return $data;
	}
}
