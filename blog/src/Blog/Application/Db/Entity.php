<?php
namespace Blog\Application\Db;

class Entity
{
	protected $table = 'posts';

	private $conn;

	public function __construct(\PDO $conn)
	{
		$this->conn = $conn;
	}

	public function insert($data)
	{
		$sql  = "INSERT INTO " . $this->table;
		$sql .= " VALUES(NULL, :title, :content, NOW(), NOW())";

		try {
			$insert = $this->conn->prepare($sql);
			$insert->bindValue(":title", $data['title'], \PDO::PARAM_STR);
			$insert->bindValue(":content", $data['content'], \PDO::PARAM_STR);

			if(!$insert->execute()) {
				return false; 
			}
			return true;
		} catch(PDOexception $e) {
			return $e->getMessage();
		}
	}

	public function getAll()
	{
		$sql = "SELECT * FROM " . $this->table;

		try{
			$select = $this->conn->prepare($sql);
			$select->execute();

		} catch(PDOexception $e) {
			return $e->getMessage();
		}

		return $select->fetchAll();
	}
	
	public function find($id)
	{
		$sql = "SELECT * FROM " . $this->table . " WHERE id = :id";

		try{
			$select = $this->conn->prepare($sql);
			$select->bindValue(':id', $id, \PDO::PARAM_INT);
			$select->execute();

		} catch(PDOexception $e) {
			return $e->getMessage();
		}

		return $select->fetchAll();
	}

	public function delete($id)
	{
		$sql = "DELETE FROM " . $this->table . " WHERE id = :id";

		try{
			$delete = $this->conn->prepare($sql);
			$delete->bindValue(':id', $id, \PDO::PARAM_INT);
			
			return $delete->execute();

		} catch(PDOexception $e) {
			return $e->getMessage();
		}

	}

	public function update($data)
	{
		$sql  = "UPDATE " .$this->table;
		$sql .= " SET title = :title, content = :content";
		$sql .= ", updated_at = NOW() WHERE id = :id";
	
	    try {
	    	$update = $this->conn->prepare($sql);

	    	$update->bindValue(":title", $data['title'] , \PDO::PARAM_STR);
	    	$update->bindValue(":content", $data['content'] , \PDO::PARAM_STR);
	    	$update->bindValue(":id", $data['id'] , \PDO::PARAM_INT);

	    	return $update->execute();

	    } catch(PDOexception $e) {
	    	return $e->getMessage();
	    }
	}
}