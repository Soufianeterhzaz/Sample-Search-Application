<?php
App::uses('AppController', 'Controller');

class QueryTicketsController extends AppController {

	public $uses = array('Ticket');

	public $components = array('Search.Prg', 'Paginator');

/**
 * Fields to preset in search forms.
 *
 * @var array $presetVars
 * @see Search.PrgComponent
 * @access public
 */
	public $presetVars = array(
		array('field' => 'title', 'type' => 'value'),
		array('field' => 'status', 'type' => 'value'),
	);

/**
 * Before filter callback
 * Pass the correct Game data to the view where needed
 *
 * @return void
 * @access public
 */
	public function beforeFilter() {
		$this->set('statuses', $this->Ticket->statuses);
		$this->set('categories', $this->Ticket->categories);
		parent::beforeFilter();
	}

	public function index() {
		$this->Prg->commonProcess();
		$this->Paginator->settings = array(
			'paramType' => 'querystring',
			'limit' => 1,
			'conditions' => $this->Ticket->parseCriteria($this->passedArgs));
		$this->set('tickets', $this->Paginator->paginate());
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ticket'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ticket', $this->Ticket->read(null, $id));
	}

	public function add() {
		if (!empty($this->request->data)) {
			$this->Ticket->create();
			if ($this->Ticket->save($this->request->data)) {
				$this->Session->setFlash(__('The ticket has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticket could not be saved. Please, try again.'));
			}
		}
	}

	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid ticket'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Ticket->save($this->request->data)) {
				$this->Session->setFlash(__('The ticket has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticket could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Ticket->read(null, $id);
		}
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ticket'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Ticket->delete($id)) {
			$this->Session->setFlash(__('Ticket deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Ticket was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

}
