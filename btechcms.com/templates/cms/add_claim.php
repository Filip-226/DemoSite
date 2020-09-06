<?php
	include_once('../../config.php');
	echo "inserted";
	die;
	//Check if upload button is clicked and submit
// 	if(
// 		isset($_POST['layerid']) && 
// 		isset($_POST['popd']) && 
// 		isset($_SESSION['userId'])
// 	){
// 		$annotation_id = $_POST['layerid'];
// 		$annotation_comment = $_POST['popd'];
// 		$researcher_id = $_SESSION['userId'];

// 		try {
// 		//Add Images to database
// 			$stmt = $db_con->prepare("
// 		          INSERT INTO `annotation_comments`(`annotation_id`, `annotation_comment`, `researcher_id`) VALUES
// 		              (:annotation_id, :annotation_comment, :researcher_id)
// 		      ");
// 			$stmt->bindParam(":annotation_id", $annotation_id);
// 			$stmt->bindParam(":annotation_comment", $annotation_comment);
// 			$stmt->bindParam(":researcher_id", $researcher_id);
// 			$stmt->execute();

// 			$stmt = $db_con->prepare("SET SESSION group_concat_max_len = 10000000000000000;");
//   			$stmt->execute();

// 			//Get Annotations
// 		    $stmt = $db_con->prepare("SELECT GROUP_CONCAT(`annotation_comments`.`annotation_comment` SEPARATOR '') AS `annotation_comment`
// 		        FROM `annotation_comments` 
// 		        WHERE `annotation_comments`.`annotation_id` = :id GROUP BY `annotation_comments`.`annotation_id`");

// 		    $stmt->bindParam(":id", $annotation_id);
// 		    $stmt->execute();
// 		    $comments = $stmt->fetch(PDO::FETCH_ASSOC);

// 		    echo($comments['annotation_comment']);
// 		    die;
// 		} catch (Exception $e) {
// 		    die($e);
// 		}
// 	}