<?php
$connectUrl = array(
	'plugin' => 'twitter', 'controller' => 'twitter',
	'action' => 'connect'
);
if (isset($url)) {
	$url = serialize($url);
	$url = bin2hex($url);
	$connectUrl[] = $url;
}
$connectLink = $this->Html->link('Connect with Twitter', $connectUrl);
echo $this->Form->inputs(array(
	'legend' => 'Twitter',
	'twitter_oauth_token' => array(
		'type' => 'text',
		'label' => 'OAuth Token',
		'value' => $this->Session->read('OAuth.twitter.oauth_token')
	),
	'twitter_oauth_token_secret' => array(
		'type' => 'text',
		'label' => 'OAuth Token Secret',
		'value' => $this->Session->read('OAuth.twitter.oauth_token_secret'),
		'after' => 
			$this->Html->tag('br /').
			$this->Html->div('note', $connectLink)
	),
));
