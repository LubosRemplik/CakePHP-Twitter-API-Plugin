<?php
App::uses('AppModel', 'App.Model');
App::uses('CakeSession', 'Model/Datasource');
App::uses('Hash', 'Utility');
App::uses('HttpSocket', 'Network/Http');
App::uses('Set', 'Utility');
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
		if (!CakeSession::check($this->_strategy)) {
			$config = ClassRegistry::init('Opauth.OpauthSetting')
				->findByName($this->_strategy);
			if (!empty($config['OpauthSetting'])) {
				CakeSession::write($this->_strategy, $config['OpauthSetting']);
			}
		}
		$this->_config = CakeSession::read($this->_strategy);
	}

	protected function _generateCacheKey() {
		$backtrace = debug_backtrace();
		$cacheKey = array();
		$cacheKey[] = $this->alias;
		if (!empty($backtrace[2]['function'])) {
			$cacheKey[] = $backtrace[2]['function'];
		}
		if ($backtrace[2]['args']) {
			$cacheKey[] = md5(serialize($backtrace[2]['args']));	
		}
		return implode('_', $cacheKey);
	}

	protected function _parseResponse($response) {
		$results = json_decode($response->body);
		$results = Set::reverse($results);
		return $results;
	}

	protected function _request($path, $request = array()) {
		// preparing request
		$request = Hash::merge($this->_request, $request);
		$request['uri']['path'] .= $path;
		$strlen = strlen($request['uri']['path']);
		if (substr($request['uri']['path'], $strlen-5, 5) != '.json') {
			$request['uri']['path'] .= '.json';
		}

		// Read cached GET results
		if ($request['method'] == 'GET') {
			$cacheKey = $this->_generateCacheKey();
			$results = Cache::read($cacheKey);
			if ($results !== false) {
				return $results;
			}
		}

		// createding http socket object with auth configuration
		$HttpSocket = new HttpSocket();
		$HttpSocket->configAuth('OauthLib.Oauth', array(
			'Consumer' => array(
				'consumer_token' => $this->_config['key'],
				'consumer_secret' => $this->_config['secret'],
			),
			'Token' => array(
				'token' => $this->_config['token'],
				'secret' => $this->_config['secret2']
			)
		));

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

		// cache and return results
		if ($request['method'] == 'GET') {
			Cache::write($cacheKey, $results);
		}
		return $results;
	}
}
