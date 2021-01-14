<?php

	include 'dbconnect.php';

	if($_POST['action'] == 'add_note'){
		try {
			
			$name = $_POST['data']["name"];
			$description = $_POST['data']["description"];
			///pdo
			$pdo->beginTransaction();
			$prepared_statement = $pdo->prepare("INSERT notes (title,description,user_id,status) VALUES (?,?,?,?)");
			echo json_encode($name);
			echo json_encode($description);

			$prepared_statement->execute(array($name, $description, 1, 1));

				echo $pdo->lastInsertId();

			$pdo->commit();
		} catch (Exception $e) {
			$pdo->rollback();
			throw $e;
		}
	}else if($_POST['action'] == 'get_notes'){
		$user_id = $_POST['user_id'];
		try {
			$sql = "SELECT * FROM  notes WHERE user_id = $user_id AND status = 1";
			$stm = $pdo->query($sql);
			$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($rows);
		} catch (Exception $e) {

			throw $e;
		}

	}else if($_POST['action'] == 'delete_note'){
		
		$note_id =  intval($_POST['id']);
		try {
			
			$pdo->beginTransaction();
			$prepared_statement = $pdo->prepare("DELETE FROM notes WHERE id=?");

			$prepared_statement->execute(array($note_id));

			$pdo->commit();

			echo "deleted";
		} catch (Exception $e) {
			$pdo->rollback();
			throw $e;
		}

	}

?>	