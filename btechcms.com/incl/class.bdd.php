<?php
class Bdd {
	private $_pdo;

	public $config = [],
		$error,
		$errno,
		$queries = [],
		$result;
		
	function __construct($host=DB_HOST, $user=DB_USER, $pass=DB_PASS, $name=DB_NAME) {
		if ($host)
			$this->config['host'] = $host;
		if ($user)
			$this->config['user'] = $user;
		if ($name)
			$this->config['name'] = $name;
		$this->config['pass'] = $pass;
		$this->error = null;
		$this->_pdo = $this->connect();
		$this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	
	private function connect() {
		$pdo = new PDO(
			"mysql:dbname=" . $this->config['name'] .
			";host=" . $this->config['host'],
			$this->config['user'],
			$this->config['pass']
		);
		$pdo->exec("SET NAMES utf8");
		return $pdo;
	}
	
	function query($sql, $params=[]) {
		$sql = trim($sql);
		$this->requete[] = $sql;
		$query = $this->_pdo->prepare($sql);
		$res = $query->execute($params);
		if ($res === false)
			throw new Exception($this->_pdo->errorInfo()[2]);
		if (preg_match("`^select`i", $sql))
			return $query->fetchAll(PDO::FETCH_ASSOC);
		if (preg_match("`^insert`i", $sql))
			return $this->_pdo->lastInsertId();
		if (preg_match("`^update`i", $sql))
			return $query->rowCount();
		return $res;

	}

}
?>
