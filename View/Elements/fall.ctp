<?php
App::uses('TwitterHelper', 'Twitter.View/Helper');
App::uses('TwitterStatuses', 'Twitter.Model');
$TTS = new TwitterStatuses();
$TTH = new TwitterHelper($this);
$data = $TTS->userTimeline(array(
	'count' => 5,
	'include_rts' => true 
));
$output = '';
if (!empty($data)) {
	$tweets = '';
	foreach ($data as $item) {
		$tweet = '';
		$tweet .= $item['text'];
		$tweets .= $this->Html->div('tweet', $tweet);
	}
	$output .= $TTH->parseContent($tweets); 
} else {
	$output .= $this->element('Frontpage.no_data');
}
$output = $this->Html->div(null, $output, array('id' => 'twitter-fall'));
echo $output;
