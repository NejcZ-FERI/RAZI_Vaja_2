<?php

require_once 'users.php';

class Comment {
	public $id;
	public $ad_id;
	public $user_id;
	public $text;

	public function __construct($id, $ad_id, $user_id, $text) {
		$this->id = $id;
		$this->ad_id = $ad_id;
		$this->user = User::find($user_id);
		$this->text = $text;
	}
	public static function find($id) {
		$db = Db::getInstance();
		$id = mysqli_real_escape_string($db, $id);
		$query = "SELECT * FROM comments WHERE id = '$id';";
		$res = $db->query($query);
		$comments = array();

		if ($comment = $res->fetch_object()) {
			return new Comment($comment->id, $comment->ad_id, $comment->user_id, $comment->text);
		}

		return null;
	}
	public static function getAll($ad_id) {
		$db = Db::getInstance();
		$ad_id = mysqli_real_escape_string($db, $ad_id);
		$query = "SELECT * FROM comments WHERE ad_id = '$ad_id';";
		$res = $db->query($query);
		$comments = array();

		while ($comment = $res->fetch_object()) {
			$comments[] = new Comment($comment->id, $comment->ad_id, $comment->user_id, $comment->text);
		}

		return $comments;
	}
	public static function add($ad_id, $text) {
		$db = Db::getInstance();
		$ad_id = mysqli_real_escape_string($db, $ad_id);
		$user_id = mysqli_real_escape_string($db, $_SESSION["USER_ID"]);
		$text = mysqli_real_escape_string($db, $text);

		$query = "INSERT INTO coomments (ad_id, user_id, text)
                	VALUES ('$ad_id', '$user_id', '$text');";

		if ($db->query($query)) {
			return true;
		}

		return false;
	}
	public function delete() {
		$db = Db::getInstance();
		$id = mysqli_real_escape_string($db, $this->id);
		$query = "DELETE FROM comments WHERE id = '$id';";

		if ($db->query($query)) {
			return true;
		}

		return false;
	}
}