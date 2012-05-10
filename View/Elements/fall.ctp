<?php
App::uses('TwitterHelper', 'Twitter.View/Helper');
$this->Twitter = new TwitterHelper($this);
$data = $this->requestAction(array(
	'plugin' => 'twitter',
	'controller' => 'twitter',
	'action' => 'userTimeline'
));
$output = '';
$output .= $this->Html->tag('h2', 'Twitter fall');
if (!empty($data)) {
	$tweets = '';
	foreach ($data as $item) {
		$tweet = '';
		$tweet .= $item['text'];
		$tweets .= $this->Html->div('tweet', $tweet);
	}
	$output .= $this->Twitter->parseContent($tweets); 
} else {
	$output .= $this->element('Frontpage.no_data');
}
$output = $this->Html->div(null, $output, array('id' => 'twitter-fall'));
echo $output;
