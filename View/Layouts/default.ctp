<?php
/* SVN FILE: $Id$ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo __('CakePHP Twitter Plugin by @neilcrookes'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $html->meta('icon');

		echo $html->css('cake.generic');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $html->link(__('CakePHP Twitter Plugin by @neilcrookes'), 'http://twitter.com/neilcrookes'); ?></h1>
		</div>
		<div id="content">
      <?php if (!$this->Session->read('Twitter.Auth.isAuthorized')) : ?>
        <?php echo $this->element('oauth_login_link'); ?>
      <?php else : ?>
        <?php echo $this->Html->link(__('Logout'), array('action' => 'logout')); ?>
      <?php endif; ?>
      <ul>
        <?php
        $nav = array(
          'Public' => array(
            'action' => 'index',
            'type' => 'publicTimeline'
          ),
          'Home' => array(
            'action' => 'index',
            'type' => 'homeTimeline'
          ),
          'User' => array(
            'action' => 'index',
            'type' => 'userTimeline',
            'screen_name' => 'neilcrookes'
          ),
          'Mentions' => array(
            'action' => 'index',
            'type' => 'mentions'
          ),
          'Retweeted by me' => array(
            'action' => 'index',
            'type' => 'retweetedByMe'
          ),
          'Retweeted to me' => array(
            'action' => 'index',
            'type' => 'retweetedToMe'
          ),
          'Retweets of me' => array(
            'action' => 'index',
            'type' => 'retweetsOfMe'
          ),
          'Friends' => array(
            'controller' => 'twitter_users',
            'action' => 'index',
            'type' => 'friends'
          ),
        );
        foreach ($nav as $text => $url) {
          echo '<li>' . $html->link(__($text), $url) . '</li>';
        }
        ?>
      </ul>
			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php echo $html->link(
					$html->image('cake.power.gif', array('alt'=> __("CakePHP: the rapid development php framework"), 'border'=>"0")),
					'http://www.cakephp.org/',
					array('target'=>'_blank'), null, false
				);
			?>
		</div>
	</div>
</body>
</html>