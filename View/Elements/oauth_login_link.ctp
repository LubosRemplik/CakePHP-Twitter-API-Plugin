<?php
if (!isset($linkText)) {
  $linkText = __('Connect with Twitter');
}
echo $this->Html->link(
  $linkText,
  array(
    'plugin' => 'twitter',
	'controller' => 'twitter_app',
    'action' => 'connect',
  )
);
?>
