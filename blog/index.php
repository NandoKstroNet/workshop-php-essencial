<?php 
use Blog\Application\Db\Entity;

require 'vendor/autoload.php';

$dsn = "mysql:host=127.0.0.1;dbname=blog";
$pdo = new \PDO($dsn, 'root', '');
$pdo->setAttribute(
		\PDO::ATTR_ERRMODE, 
		\PDO::ERRMODE_EXCEPTION
	);
$pdo->exec("SET NAMES 'utf8';");

if(isset($_GET['url']) && $_GET['url'] == 'save') {

	$blog = new Entity($pdo);
	$data = [
		'title' => $_POST['title'],
		'content' => $_POST['content']
	];

	if($blog->insert($data)) {
		header('Location: index.php?url=posts');
	} else {
		print $data;
	}

}

if(isset($_GET['url']) && $_GET['url'] == 'posts') {
	
	$blog = new Entity($pdo);

	foreach($blog->getAll() as $post){
		print '<h3>' . $post['title'];
		print '<a href="/blog/index.php?url=delete&id='. $post['id'] .' ">X</a></h3>';
	}
}

if(isset($_GET['url']) && $_GET['url'] == 'single') {

	if(!isset($_GET['id']))
	{
		print 'Passe um parametro na url chamado ID';
	    die;
	}
	
	$blog = new Entity($pdo);
	$post = $blog->find($_GET['id'])[0];
	require __DIR__ . '/views/update.phtml';
}

if(isset($_GET['url']) && $_GET['url'] == 'salvar-post') {

	require __DIR__ . '/views/form.phtml';

}

if(isset($_GET['url']) && $_GET['url'] == 'delete') {
	
	if(!isset($_GET['id']))
	{
		print 'Passe um parametro na url chamado ID';
	    die;
	}

	$blog = new Entity($pdo);

    if(!$blog->delete($_GET['id'])) {
    	return 'Erro ao deletar usuario';
    }	

   header('Location: index.php?url=posts');
}

if(isset($_GET['url']) && $_GET['url'] == 'update') {
	
	if(!isset($_GET['id']))
	{
		print 'Passe um parametro na url chamado ID';
	    die;
	}

	$data = [
		'title'   => $_POST['title'],
		'content' => $_POST['content'],
		'id'      => $_GET['id']
	];

	$blog = new Entity($pdo);

	if(!$blog->update($data)) {
		return 'Erro ao atualizar o usuario!';
	}


   header('Location: index.php?url=single&id=' . $_GET['id']);

}