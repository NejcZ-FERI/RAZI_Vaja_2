<?php

require_once 'users.php';

class Ad {
	public $id;
	public $title;
	public $description;
	public $views;
	public $user_id;
	public $published;

	public function __construct($id, $title, $description, $views, $user_id, $published) {
		$this->id = $id;
		$this->title = $title;
		$this->description = $description;
		$this->views = $views;
		$this->user = User::find($user_id);
		$this->published = $published;
	}
	public static function find($id) {
		$db = Db::getInstance();
		$id = mysqli_real_escape_string($db, $id);
		$query = "SELECT * FROM ads WHERE id = '$id';";
		$res = $db->query($query);

		if ($ad = $res->fetch_object()) {
			return new Ad($ad->id, $ad->title, $ad->description, $ad->views, $ad->user_id, $ad->published);
		}

		return null;
	}
}