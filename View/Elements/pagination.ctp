<?php
if (isset($previous_cursor) && $next_cursor) {
  echo $this->Html->link(__('<< Prev'), array_merge($url, array('cursor' => $previous_cursor)));
  echo $this->Html->link(__('Next >>'), array_merge($url, array('cursor' => $next_cursor)));
  return;
}
echo $paginator->prev();
echo $paginator->next();
?>
