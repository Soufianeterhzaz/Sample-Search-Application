<?php
/* Ticket Test cases generated on: 2011-01-20 14:04:55 : 1295521495*/
App::uses('Ticket', 'Model');

class TicketTest extends CakeTestCase {
	public $fixtures = array('app.ticket');

	function startTest() {
		$this->Ticket =& ClassRegistry::init('Ticket');
	}

	function endTest() {
		unset($this->Ticket);
		ClassRegistry::flush();
	}

}
