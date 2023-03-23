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
	public static function getAll() {
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
	public static function add($username, $password, $repeatPassword, $email, $name, $surname, $address, $zipcode, $phone_number) {
		if ($password != $repeatPassword) {
			return false;
		}

		$db = Db::getInstance();
		$username = mysqli_real_escape_string($db, $username);
		$query = "SELECT * FROM users WHERE username='$username'";
		$res = $db->query($query);

		if (mysqli_num_rows($res) > 0) {
			return false;
		}

		$email = mysqli_real_escape_string($db, $email);
		$query = "SELECT * FROM users WHERE email='$email'";
		$res = $db->query($query);

		if (mysqli_num_rows($res) > 0) {
			return false;
		}

		$name = mysqli_real_escape_string($db, $name);
		$surname = mysqli_real_escape_string($db, $surname);
		$address = mysqli_real_escape_string($db, $address);
		$zipcode = mysqli_real_escape_string($db, $zipcode);
		$phone_number = mysqli_real_escape_string($db, $phone_number);
		$pass = sha1($password);
		$query = "INSERT INTO users (username, password, email, name, surname, address, zipcode, phone_number)
                	VALUES ('$username', '$pass', '$email', '$name', '$surname', '$address', '$zipcode', '$phone_number');";

		if ($db->query($query)) {
			return true;
		}

		return false;
	}

	public function update($username, $password, $repeatPassword, $email, $name, $surname, $address, $zipcode, $phone_number) {
		if ($password != $repeatPassword) {
			return false;
		}

		$db = Db::getInstance();
		$id = mysqli_real_escape_string($db, $this->id);
		$username = mysqli_real_escape_string($db, $username);

		if ($username != $this->username) {
			$query = "SELECT * FROM users WHERE username='$username'";
			$res = $db->query($query);

			if (mysqli_num_rows($res) > 0) {
				return false;
			}
		}

		$email = mysqli_real_escape_string($db, $email);

		if ($email != $this->email) {
			$query = "SELECT * FROM users WHERE email='$email'";
			$res = $db->query($query);

			if (mysqli_num_rows($res) > 0) {
				return false;
			}
		}

		$name = mysqli_real_escape_string($db, $name);
		$surname = mysqli_real_escape_string($db, $surname);
		$address = mysqli_real_escape_string($db, $address);
		$zipcode = mysqli_real_escape_string($db, $zipcode);
		$phone_number = mysqli_real_escape_string($db, $phone_number);

		if (empty($password)) {
			$pass = $this->password;
		} else {
			$pass = sha1($password);
		}

		$query = "UPDATE users SET username = '$username', password = '$pass', email = '$email', name = '$name', surname = '$surname', address = '$address', zipcode = '$zipcode', phone_number = '$phone_number' WHERE id = '$id';";

		if ($db->query($query)) {
			return true;
		}

		return false;
	}

	public function delete() {
		$db = Db::getInstance();
		$id = mysqli_real_escape_string($db, $this->id);
		$query = "SELECT * FROM ads WHERE ads.user_id = '$id';";
		$res = $db->query($query);
		$query = "";

		while ($obj = $res->fetch_object()) {
			$query .= "DELETE FROM ads WHERE id = '$obj->id';
					DELETE FROM ads_categories WHERE ad_id = '$obj->id';
					DELETE FROM images WHERE ad_id = '$obj->id';";
		}

		$query .= "DELETE FROM users WHERE id = '$id';";

		if ($db->multi_query($query)) {
			return true;
		}

		return false;
	}
}