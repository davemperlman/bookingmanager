<?php

/**
* 
*/
class Prospect_Tracker {
	
	public $pdo;
	public $prospects;

	function __construct() {
		$this->pdo = new PDO("mysql:host=localhost;dbname=musicprospects", 'root', 'root');
		$this->get_prospects();
	}

	public function set_prospect($args) {
		isset($args['booked']) ? $args['booked'] = 1 : $args['booked'] = 0;
		$stmt = $this->pdo->prepare("INSERT INTO prospects (name, location, method, comments, booked, date) VALUES(:venue, :location, :method, :comments, :booked, :date)");
		$stmt->execute( array(
			':venue' 	=> $args['venue'],
			':location' => $args['location'],
			':method'   => $args['method'],
			':comments' => $args['comments'],
			':booked'   => $args['booked'],
			':date'     => date('Y-m-d h:i:s')
			)
		);
	}

	private function get_prospects() {
		$this->prospects = $this->pdo->query('SELECT * FROM prospects WHERE date > NOW() - INTERVAL 1 week')->fetchAll(PDO::FETCH_ASSOC);
		$this->action_needed = $this->pdo->query('SELECT * FROM prospects WHERE date < NOW() - INTERVAL 1 week AND booked != 1')->fetchAll(PDO::FETCH_ASSOC);
	}

	public function update_prospect($args) {
		isset($args['update-booked']) ? $args['update-booked'] = 1 : $args['update-booked'] = 0;
		$stmt = $this->pdo->prepare("UPDATE prospects SET method = :method, comments = :comments, booked = :booked, date = :date WHERE id = :id");
		$stmt->execute( array(
			':method'	=> $args['update-method'],
			':comments'	=> $args['update-comments'],
			':booked'	=> $args['update-booked'],
			':date'		=> date('Y-m-d h:i:s'),
			':id'		=> $args['submit-form']
			)
		);
	}
}