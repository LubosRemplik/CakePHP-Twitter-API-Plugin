<?php
/**
	* Twitter Driver for Apis Source
	* 
	* Makes usage of the Apis plugin by Proloser
	*
	* @package Twitter Datasource
	* @author Dean Sofer
	* @version 0.0.1
	**/
App::uses('ApisSource', 'Apis.Model/Datasource');
class Twitter extends ApisSource {

	public $_schema = array(
		'tweets' => array(
			'id' => array(
				'type' => 'integer',
				'null' => true,
				'key' => 'primary',
				'length' => 11,
			),
			'text' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140,
			),
			'status' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140,
			),
		),
	);

	/**
	 * The description of this data source
	 *
	 * @var string
	 */
	public $description = 'Twitter DataSource';

	/**
	 * Set the datasource to use OAuth
	 *
	 * @param array $config
	 * @param HttpSocket $Http
	 */
	public function __construct($config) {
		$config['method'] = 'OAuth';
		parent::__construct($config);
	}

	public function describe($model) {
		return $this->_schema['tweets'];
	}

	public function read(&$model, $queryData = array()) {
		if (!isset($model->request)) {
			$model->request = array();
		}
		$model->request = array_merge(
			array('method' => 'GET'), 
			$model->request
		);
		if (empty($model->request['uri']['path']) 
		&& !empty($queryData['path'])) {
			$model->request['uri']['path'] = $queryData['path'];
		} 
		if (empty($model->request['uri']['query']) 
		&& !empty($queryData['query'])) {
			$model->request['uri']['query'] = $queryData['query'];
		} 
		return $this->request($model);
	}

	/**
	 * Supplement the request object with github-specific data
	 *
	 * @param array $request 
	 * @return array $response
	 */
	public function beforeRequest(&$model, $request) {
		$request['uri']['scheme'] = 'https';
		// Attempted fix for 3.0
		if (strtoupper($request['method']) === 'GET' && !empty($this->config['access_token'])) {
			$request['uri']['query']['access_token'] = $this->config['access_token'];
		}
		$request['uri']['path'] .= '.' . $this->options['format'];
		return $request;
	}
}
