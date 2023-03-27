<?php

require_once 'users.php';
require_once 'ads.php';

class Comment {
	public $id;
	public $ad;
	public $user;
	public $text;
	public $published;

	public function __construct($id, $ad_id, $user_id, $text, $published) {
		$this->id = $id;
		$this->ad = Ad::find($ad_id);
		$this->user = User::find($user_id);
		$this->text = $text;
		$this->published = $published;
	}
	public static function find($id) {
		$db = Db::getInstance();
		$id = mysqli_real_escape_string($db, $id);
		$query = "SELECT * FROM comments WHERE id = '$id';";
		$res = $db->query($query);

		if ($comment = $res->fetch_object()) {
			return new Comment($comment->id, $comment->ad_id, $comment->user_id, $comment->text, $comment->published);
		}

		return null;
	}
	public static function getAll($ad_id) {
		$db = Db::getInstance();
		$ad_id = mysqli_real_escape_string($db, $ad_id);
		$query = "SELECT * FROM comments WHERE ad_id = '$ad_id' ORDER BY published DESC;";
		$res = $db->query($query);
		$comments = array();

		while ($comment = $res->fetch_object()) {
			$comments[] = new Comment($comment->id, $comment->ad_id, $comment->user_id, $comment->text, $comment->published);
		}

		return $comments;
	}
    public static function returnLastFive() {
        $db = Db::getInstance();
        $query = "SELECT * FROM comments ORDER BY published DESC LIMIT 5;";
        $res = $db->query($query);
        $comments = array();

        while ($comment = $res->fetch_object()) {
            $comments[] = new Comment($comment->id, $comment->ad_id, $comment->user_id, $comment->text, $comment->published);
        }

        return $comments;
    }
	public static function add($ad_id, $text) {
		if (!isset($_SESSION["USER_ID"])) {
			return null;
		}

		$db = Db::getInstance();
		$ad_id = mysqli_real_escape_string($db, $ad_id);
		$user_id = mysqli_real_escape_string($db, $_SESSION["USER_ID"]);
		$text = mysqli_real_escape_string($db, $text);

		$query = "INSERT INTO comments (ad_id, user_id, text, published)
                	VALUES ('$ad_id', '$user_id', '$text', NOW());";

		if ($db->query($query)) {
			$id = mysqli_insert_id($db);
			return Comment::find($id);
		} else {
			return null;
		}
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