<?php
App::uses('CakeSession', 'Model/Datasource');
if (!CakeSession::check('OAuth.twitter.oauth_token')
|| !CakeSession::check('OAuth.twitter.oauth_token_secret')) {
	App::uses('AppPreference', 'App.Model');
	CakePlugin::loadAll(array('User', 'UniqueKey'));
	$AppPreference = new AppPreference();
	$data = $AppPreference->find('first', array(
		'fields' => 'AppPreference.*',
		'contain' => array('AppPreferenceExpanded')
	));
	if (!empty($data['AppPreference']['twitter_oauth_token'])) {
		CakeSession::write(
			'OAuth.twitter.oauth_token',
			$data['AppPreference']['twitter_oauth_token']
		);
	}
	if (!empty($data['AppPreference']['twitter_oauth_token_secret'])) {
		CakeSession::write(
			'OAuth.twitter.oauth_token_secret',
			$data['AppPreference']['twitter_oauth_token_secret']
		);
	}
}
