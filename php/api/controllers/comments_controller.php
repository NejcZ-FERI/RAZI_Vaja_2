<?php

class comments_controller {
    public function index($ad_id) {
        $comments = Comment::getAll($ad_id);
        echo json_encode($comments);
    }
    public function add() {
        if (Comment::add($_POST["ad_id"], $_POST["title"])) {
			echo json_encode((object)["status"=>"200", "message"=>"Comment added"]);
		} else {
			echo json_encode((object)["status"=>"500", "message"=>"Invalid parameters"]);
		}
    }
    public function delete($ad_id, $id) {
		$comment = Comment::find($id);

		$success = false;

		if ($comment->ad_id == $ad_id) {
			$success = $comment->delete();
		}

		if ($success) {
			echo json_encode((object)["status"=>"200", "message"=>"Comment deleted"]);
		} else {
			echo json_encode((object)["status"=>"500", "message"=>"Invalid parameters"]);
		}
	}
}
