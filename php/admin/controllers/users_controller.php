<?php
class users_controller {
    public function index() {
        $users = User::getAll();
        require_once('views/users/index.php');
    }
    public function create() {
        require_once('views/users/create.php');
    }
    public function add() {
		if (!User::add($_POST["username"], $_POST["password"], $_POST["repeat_password"], $_POST["email"], $_POST["name"], $_POST["surname"], $_POST['address'], $_POST['zipcode'], $_POST['phone_number'])) {
			return call('users', 'error');
		}

        require_once('views/users/createSuccess.php');
    }
    public function edit() {
        if (!isset($_GET['id'])) {
            return call('users', 'error');
        }

        $user = User::find($_GET['id']);
        require_once('views/users/edit.php');
    }
    public function update() {
        if (!isset($_POST['id'])) {
            return call('users', 'error');
        }

        $user = User::find($_POST['id']);

		if (!$user->update($_POST["username"], $_POST["password"], $_POST["repeat_password"], $_POST["email"], $_POST["name"], $_POST["surname"], $_POST['address'], $_POST['zipcode'], $_POST['phone_number'])) {
			return call('users', 'error');
		}

        require_once('views/users/editSuccess.php');
    }
    public function delete() {
        if (!isset($_GET['id'])) {
            return call('users', 'error');
        }

        $ad = Ad::find($_GET['id']);

        require_once('views/ads/deleteSuccess.php');
    }
	public function error() {
		require_once('views/users/error.php');
	}
}
