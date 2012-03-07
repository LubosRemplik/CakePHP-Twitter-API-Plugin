<?php
if (!isset($linkText)) {
  $linkText = __('Connect with Twitter');
}
echo $this->Html->link(
  $linkText,
  array(
    'plugin' => 'twitter',
    'action' => 'connect',
    urlencode(urlencode(urlencode($this->here)))
  )
);
?>