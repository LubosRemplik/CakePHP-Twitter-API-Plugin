<?php
App::uses('AppModel', 'App.Model');
App::uses('CakeSession', 'Model/Datasource');
App::uses('Hash', 'Utility');
App::uses('HttpSocket', 'Network/Http');
App::uses('Set', 'Utility');
App::uses('OauthHelper', 'OauthLib.Lib');
App::uses('Consumer', 'OauthLib.Lib');
App::uses('RequestToken', 'OauthLib.Lib');
App::uses('RequestFactory', 'OauthLib.Lib');
class TwitterApi extends AppModel {

	public $useTable = false;
	
	protected $_config = array();

	protected $_request = array(
		'method' => 'GET',
		'uri' => array(
			'scheme' => 'https',
			'host' => 'api.twitter.com',
			'path' => '/1.1',
		)
	);

	protected $_strategy = 'Twitter';

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$session = CakeSession::read($this->_strategy);
		$configure = Configure::read(sprintf(
			'Opauth.Strategy.%s', 
			$this->_strategy
		));
		if (!empty($session) && !empty($configure)) {
			$this->_config = array_merge($session, $configure);
		}
	}

	protected function _parseResponse($response) {
		$results = json_decode($response->body);
		$results = Set::reverse($results);
		return $results;
	}

	protected function _request($path, $request = array()) {
		// createding http socket object for later use
		$HttpSocket = new HttpSocket();

		// preparing request
		$request = Hash::merge($this->_request, $request);
		$request['uri']['path'] .= $path;
		$parameters = array(
			'oauth_consumer_key' => $this->_config['key'],
			'oauth_nonce' => OauthHelper::generateKey(),
			'oauth_timestamp' => time(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_version' => '1.0',
			'oauth_token' => $this->_config['credentials']['token']
		);
		$Request = RequestFactory::proxy(new MockObject(array(
			'parameters' => $parameters, 
			'method' => $request['method'], 
			'uri' => $HttpSocket->url($request['uri'], '%scheme://%user:%pass@%host:%port/%path?%query#%fragment')
		)));
		$signature = $Request->sign(array(
			'consumer_secret' => $this->_config['secret'], 
			'token_secret' => $this->_config['credentials']['secret']
		));	
		$request['header'] = array(
			'Authorization' => $Request->oauthHeader()
		);

		// issuing request
		$response = $HttpSocket->request($request);

		// olny valid response is going to be parsed
		if ($response->code != 200) {
			if (Configure::read('debug')) {
				debug($request);
				debug($response->body);
			}
			return false;
		}

		// parsing response
		$results = $this->_parseResponse($response);

		// return results
		return $results;
	}
}
