<?php
class TweetableBehavior extends ModelBehavior {

	public function setup($model, $settings = array()) {
		if (!isset($this->settings[$model->alias])) {
			$this->settings[$model->alias] = array(
				'scope' => array(),
				'append' => ''
			);
		}
		$this->settings[$model->alias] = array_merge(
			$this->settings[$model->alias], 
			(array) $settings
		);
	}

	public function afterSave($model, $created) {
		$allowed = true;
		if (empty($model->data)) {
			$model->data = $model->read();
		}
		if (!empty($this->settings[$model->alias]['scope'])) {
			foreach ($this->settings[$model->alias]['scope'] as $field => $value) {
				if ($model->data[$model->alias][$field] != $value) {
					$allowed = false;
				}
			}
		}
		if (empty($model->data[$model->alias]['title'])) {
			$allowed = false;
		}
		if ($allowed) {
			$tweet = $model->data[$model->alias]['title'];
			if (!empty($this->settings[$model->alias]['append'])) {
				$tweet .= ' ';
				$tweet .= $this->settings[$model->alias]['append'];	
			}
			$TwitterStatuses = ClassRegistry::init('Twitter.TwitterStatuses');
			if ($TwitterStatuses->update($tweet)) {
				Cache::clear();
			}
		}
		return true;
	}
}
