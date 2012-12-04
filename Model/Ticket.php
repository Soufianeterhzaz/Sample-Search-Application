<?php

App::uses('AppModel', 'Model');

class Ticket extends AppModel {

/**
 * Validation parameters - initialized in constructor
 *
 * @var array
 */
	public $validate = array(
		'status' => array(
			'notempty' => array(
				'rule' => array('notempty'))),
		'category' => array(
			'notempty' => array(
				'rule' => array('notempty'))),
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'))));

/**
 * Behaviors
 *
 * @var array
 * @access public
 */
	public $actsAs = array(
		'Search.Searchable');

/**
 * Field names accepted for search queries.
 *
 * @var array
 * @see SearchableBehavior
 */
	public $filterArgs = array(
		array('name' => 'title', 'type' => 'query', 'method' => 'filterTitle'),
		array('name' => 'status', 'type' => 'string'),
	);

/**
 * Constructor
 *
 * @param mixed $id Model ID
 * @param string $table Table name
 * @param string $ds Datasource
 * @access public
 */
	public function __construct($id = false, $table = null, $ds = null) {
		$this->statuses = array(
			'open' => __('Open'),
			'closed' => __('Closed'));
		$this->categories = array(
			'bug' => __('Bug'),
			'support' => __('Support'),
			'technical' => __('Technical'),
			'other' => __('Other'));
		parent::__construct($id, $table, $ds);
	}

	public function filterTitle($data, $field = null) {
		if (empty($data['title'])) {
			return array();
		}
		$title = '%' . $data['title'] . '%';
		return array(
			'OR'  => array(
				$this->alias . '.title LIKE' => $title,
				$this->alias . '.content LIKE' => $title,
			));
	}

}
