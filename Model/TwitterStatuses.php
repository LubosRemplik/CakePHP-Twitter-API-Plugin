<?php
App::uses('TwitterAppModel', 'Twitter.Model');
class TwitterStatuses extends TwitterAppModel {
	
	/**
	 * https://dev.twitter.com/docs/api/1/get/statuses/home_timeline
	 **/
	public function homeTimeline($query = null) {
		$cacheKey = $this->_generateCacheKey('homeTimeline', $query);
		if (($data = Cache::read($cacheKey)) === false) {
			$options = array('path' => 'statuses/home_timeline');
			if ($query) {
				$options['query'] = $query;
			}
			$data = $this->find('all', $options);
			Cache::write($cacheKey, $data);
		}
		return $data;
	}

	/**
	 * https://dev.twitter.com/docs/api/1/get/statuses/user_timeline
	 **/
	public function userTimeline($query = null) {
		$cacheKey = $this->_generateCacheKey('userTimeline', $query);
		if (($data = Cache::read($cacheKey)) === false) {
			$options = array('path' => 'statuses/user_timeline');
			if ($query) {
				$options['query'] = $query;
			}
			$data = $this->find('all', $options);
			
			foreach($data as $k => $v) {
				$data[$k]['text'] = str_replace(
					array('&lt;', '&gt;'),
					'',
					$data[$k]['text']
				);
			}
			
			Cache::write($cacheKey, $data);
		}
		return $data;
	}
}
