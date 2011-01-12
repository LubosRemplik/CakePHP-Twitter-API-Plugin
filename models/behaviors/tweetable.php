<?php
/**
 * Tweetable Behavior
 *
 * @package twitter
 * @subpackage twitter.models.behaviors
 */
class TweetableBehavior extends ModelBehavior
{

    /**
     * setup
     *
     * @access public
     * @param Object $Model
     * @param array $config
     */
    function setup(&$Model, $config = array())
    {
        App::import('Model', 'Twitter.TwitterStatus');
        $Model->TwitterStatus = ClassRegistry::init('TwitterStatus');
    }

    /**
     * Tweets as an user.
     *
     * @access public
     * @param integer $id
     * @param string $text
     * @return boolean
     */
    function tweet(&$Model, $userID, $text)
    {
        $params = array(
            'conditions' => array(
                $Model->alias.'.id = ' => $userID,
            ),
            'fields' => array(
                $Model->alias.'.twitter_oauth_token',
                $Model->alias.'.twitter_oauth_token_secret',
            ),
            'recursive' => -1,
        );
        if (!$data = $Model->find('first', $params)) {
            return false;
        }
        $fields = array('oauth_token', 'oauth_token_secret');
        foreach ($fields as $field) {
            $dataField = 'twitter_'.$field;
            if (empty($data[$Model->alias][$dataField])) {
                return false;
            }
            $Model->TwitterStatus->request['auth'][$field] = $data[$Model->alias][$dataField];
        }
        $tweet = array(
            $Model->TwitterStatus->alias => array(
                'text' => $text,
            ),
        );
        return $Model->TwitterStatus->tweet($tweet);
    }

}
