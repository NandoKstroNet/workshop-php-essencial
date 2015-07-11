<?php 
namespace Workshop\Entity;

class Entity
{
	private $con;

	public function __construct(\PDO $con)
	{
		$this->con = $con;
	}

	public function insert($data)
	{
		$sql  = 'INSERT INTO posts(title, content, created_at, updated_at) ';
		$sql .= 'VALUES(:title, :content, NOW(), NOW())';

		try{
			$insert = $this->con->prepare($sql);
			$insert->bindValue(':title', $data['title'], \PDO::PARAM_STR);
			$insert->bindValue(':content', $data['content'], \PDO::PARAM_STR);
			
			return $insert->execute();

		}catch(PDOexception $e){
			return $e->getMessage();
		}
	}
	public function read()
	{
		$sql = 'SELECT * FROM posts';

		try{
			$read = $this->con->prepare($sql);
			$read->execute();

			return $read->fetchAll();
		}catch(PDOexception $e){
			return $e->getMessage();
		}
	}

	public function find($id)
	{
		$sql = 'SELECT * FROM posts WHERE id = :id';

		try{
			$read = $this->con->prepare($sql);
			$read->bindValue(':id', $id, \PDO::PARAM_INT);			
			$read->execute();

			return $read->fetchAll();
		}catch(PDOexception $e){
			return $e->getMessage();
		}
	}
	public function update($data)
	{
		$sql  = 'UPDATE posts ';
		$sql .= 'SET title = :title, content = :content WHERE id = :id';

		try{
			$insert = $this->con->prepare($sql);
			$insert->bindValue(':title', $data['title'], \PDO::PARAM_STR);
			$insert->bindValue(':content', $data['content'], \PDO::PARAM_STR);
			$insert->bindValue(':id', $data['id'], \PDO::PARAM_INT);
			
			return $insert->execute();

		}catch(PDOexception $e){
			return $e->getMessage();
		}
	}
	public function delete($id)
	{
		$sql = 'DELETE FROM posts WHERE id = :id';

		try{
			$delete = $this->con->prepare($sql);
			$delete->bindValue(':id', $id, \PDO::PARAM_INT);
			return $delete->execute();
		
		}catch(PDOexception $e){
			return $e->getMessage();
		}
	}
}