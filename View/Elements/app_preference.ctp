<?php
$link = $this->Html->link(
	__d('twitter', 'Connect with Twitter'), 
	array(
		'plugin' => 'Opauth', 'controller' => 'Opauth',
		'action' => 'index', 'twitter'
	)
);
$link2 = $this->Html->link(
	__d('twitter', 'Disconnect'), 
	array(
		'plugin' => 'Opauth', 'controller' => 'Opauth',
		'action' => 'disconnect', 'twitter'
	)
);
$para = '';
$para .= __d('twitter', 'You need to click "%s" and confirm following actions'.
	' to allow the application access your twitter account.', $link);
$para .= $this->Html->tag('br /');
$para .= $this->Html->tag('br /');
$para .= sprintf('%s / %s', $link, $link2);
$para = $this->Html->para('note', $para);
// because I usually implement this element in form, need to create fieldset
if (isset($fieldset) && $fieldset === false) {
	echo $para;
} else {
	$fieldset = '';
	$fieldset .= $this->Html->tag('legend', __d('twitter', 'Twitter'));
	$fieldset .= $this->Html->div('input', $para);
	$fieldset = $this->Html->tag('fieldset', $fieldset);
	echo $fieldset;
}
