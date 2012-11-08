<?php
App::uses('TwitterApi', 'Twitter.Model');
class TwitterStatuses extends TwitterApi {
	
	public function homeTimeline($query = null) {
		//$cacheKey = $this->_generateCacheKey('homeTimeline', $query);
		//if (($data = Cache::read($cacheKey)) === false) {
			$data = $this->_request('/statuses/home_timeline.json');
			//Cache::write($cacheKey, $data);
		//}
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
