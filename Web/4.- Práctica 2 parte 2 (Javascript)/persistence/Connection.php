<?php
class Connection {
	private $sqlitePath;
	
	public function __construct($sqlitePath) {
		$this->sqlitePath = $sqlitePath;
	}

	public function connect() {
		$connectionString = "sqlite:" . $this->sqlitePath;
		if (!($connection = new PDO($connectionString)))
			throw new Exception("Unable to connect to " . $this->sqlitePath . " sql file.");
		return $connection;
	}
}
?>