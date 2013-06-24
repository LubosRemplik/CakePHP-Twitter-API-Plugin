<?php
/**
 * TwitterAccount model provides custom find types and other methods for managing
 * twitter accounts through the twitter API.
 *
 * @author Takahiro Fujiwara <tfmagician@gmail.com>
 * @link http://1-byte.jp
 * @copyright (c) 2010 Takahiro Fujiwara
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class TwitterAccount extends TwitterAppModel {

  /**
   * The model's schema. Used by FormHelper
   *
   * @var array
   */
  public $_schema = array(
  );

  /**
   * Validation rules for the model
   *
   * @var array
   */
  public $validate = array(
  );

  /**
   * Custom find types available on this model
   *
   * @var array
   */
  public $_findMethods = array(
    'verifyCredentials' => true,
  );

  /**
   * The custom find types that require authentication
   *
   * @var array
   */
  public $findMethodsRequiringAuth = array(
    'verifyCredentials',
  );

  /**
   * The options allowed by each of the custom find types
   *
   * @var array
   */
  public $allowedFindOptions = array(
    'verifyCredentials'  => array('include_entities'),
  );

  /**
   * The vast majority of the custom find types actually follow the same format
   * so there was little point explicitly writing them all out. Instead, if the
   * method corresponding to the custom find type doesn't exist, the options are
   * applied to the model's request property here and then we just call
   * parent::find('all') to actually trigger the request and return the response
   * from the API.
   *
   * @param string $type
   * @param array $options
   * @return mixed
   */
  public function find($type, $options = array()) {
    if (method_exists($this, '_find' . Inflector::camelize($type))) {
      return parent::find($type, $options);
    }
    $this->request['uri']['path'] = '1.1/account/' . Inflector::underscore($type);
    if (array_key_exists($type, $this->allowedFindOptions)) {
      $this->request['uri']['query'] = array_intersect_key($options, array_flip($this->allowedFindOptions[$type]));
    }
    if (in_array($type, $this->findMethodsRequiringAuth)) {
      $this->request['auth'] = true;
    }
    return parent::find('all', $options);
  }

  /**
   * Verify Credentials
   *
   * See http://dev.twitter.com/doc/get/account/verify_credentials
   *
   * @param $state string 'before' or 'after'
   * @param $query array
   * @param $results array
   * @return mixed
   * @access protected
   */
  protected function _findVerifyCredentials($state, $query = array(), $results = array()) {
    if ($state == 'before') {
      $this->request = array(
        'uri' => array(
          'path' => '1.1/account/verify_credentials'
        ),
        'auth' => true,
      );
      if (isset($query['oauth_token']) && isset($query['oauth_token_secret'])) {
        $this->request['auth'] = array(
            'oauth_token' => $query['oauth_token'],
            'oauth_token_secret' => $query['oauth_token_secret'],
        );
      }
      $this->request['uri']['query'] = array_intersect_key($query, array_flip($this->allowedFindOptions['verifyCredentials']));
      return $query;
    } else {
      return $results;
    }
  }

}
