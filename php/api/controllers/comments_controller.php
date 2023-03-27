<?php

class comments_controller {
    public function index($ad_id) {
        $comments = Comment::getAll($ad_id);
        echo json_encode($comments);
    }
    public function returnLastFive() {
        $comments = Comment::returnLastFive();
        echo json_encode($comments);
    }
    public function add() {
		$comment = Comment::add($_POST["ad_id"], $_POST["user_ip"], $_POST["text"]);
		echo json_encode($comment);
    }
    public function delete($ad_id, $id) {
		$comment = Comment::find($id);

		if ($comment->ad->id == $ad_id && ($comment->ad->user->id == $_SESSION["USER_ID"] || (isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]))) {
			$comment = $comment->delete();
			echo json_encode($comment);
		} else {
			echo json_encode((object)["status"=>"500", "message"=>"Invalid parameters"]);
		}
	}
}
