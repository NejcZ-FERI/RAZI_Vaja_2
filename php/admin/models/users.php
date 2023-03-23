<?php
class User {
    public $id;
    public $username;
    public $password;
	public $email;
	public $name;
	public $surname;
	public $address;
	public $zipcode;
	public $phone_number;
	public $admin;

    public function __construct($id, $username, $password, $email, $name, $surname, $address, $zipcode, $phone_number, $admin) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
		$this->email = $email;
		$this->name = $name;
		$this->surname = $surname;
		$this->address = $address;
		$this->zipcode = $zipcode;
		$this->phone_number = $phone_number;
		$this->admin = $admin;
    }

    public static function find($id) {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT * FROM users WHERE id = '$id';";
        $res = $db->query($query);

        if ($user = $res->fetch_object()) {
            return new User($user->id, $user->username, $user->password, $user->email, $user->name, $user->surname, $user->address, $user->zipcode, $user->phone_number, $user->admin);
        }

        return null;
    }
	public static function getUsers() {
		$db = Db::getInstance();
		$query = "SELECT * FROM users;";
		$res = $db->query($query);
		$users = array();

		while ($user = $res->fetch_object()) {
			$users[] = new User($user->id, $user->username, $user->password, $user->email, $user->name, $user->surname, $user->address, $user->zipcode, $user->phone_number, $user->admin);
		}

		if (!empty($users)) {
			return $users;
		}

		return null;
	}
}
