<?php
include_once('header.php');

function username_exists($username) {
	global $conn;
	$username = mysqli_real_escape_string($conn, $username);
	$query = "SELECT * FROM users WHERE username='$username'";
	$res = $conn->query($query);
	return mysqli_num_rows($res) > 0;
}
function email_exists($email) {
    global $conn;
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM users WHERE email='$email'";
    $res = $conn->query($query);
    return mysqli_num_rows($res) > 0;
}
function register_user($username, $password, $email, $name, $surname, $address, $zipcode, $phone_number) {
	global $conn;
	$username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $name = mysqli_real_escape_string($conn, $name);
    $surname = mysqli_real_escape_string($conn, $surname);
    $address = mysqli_real_escape_string($conn, $address);
    $zipcode = mysqli_real_escape_string($conn, $zipcode);
    $phone_number = mysqli_real_escape_string($conn, $phone_number);
	$pass = sha1($password);
	$query = "INSERT INTO users (username, password, email, name, surname, address, zipcode, phone_number)
                VALUES ('$username', '$pass', '$email', '$name', '$surname', '$address', '$zipcode', '$phone_number');";

	if ($conn->query($query)) {
		return true;
	} else {
		echo mysqli_error($conn);
		return false;
	}
}

$error = "";

if (isset($_POST["submit"])) {
	if ($_POST["password"] != $_POST["repeat_password"]) {
		$error = "Gesli se ne ujemata.";
	} else if (username_exists($_POST["username"])) {
		$error = "Uporabniško ime je že zasedeno.";
	} else if (email_exists($_POST["email"])) {
        $error = "Email je že zaseden.";
    } else if (register_user($_POST["username"], $_POST["password"], $_POST["email"], $_POST["name"], $_POST["surname"], $_POST['address'], $_POST['zipcode'], $_POST['phone_number'])) {
		header("Location: login.php");
		die();
	} else {
		$error = "Prišlo je do napake med registracijo uporabnika.";
	}
}

?>
    <div class="container my-1">
        <br/> <h2>Registracija</h2> <br/>
        <form action="register.php" method="POST">
            <div class="form-group"><label class="form-label" for="username">Uporabniško ime</label><input type="text" class="form-control" id="username" name="username" required /></div> <br/>
            <div class="form-group"><label class="form-label" for="password">Geslo</label><input type="password" class="form-control" id="password" name="password" required /></div> <br/>
            <div class="form-group"><label class="form-label" for="repeat_password">Ponovi geslo</label><input type="password" class="form-control" id="repeat_password" name="repeat_password" required /></div> <br/>
            <div class="form-group"><label class="form-label" for="email">Email</label><input type="email" class="form-control" id="email" name="email" required /></div> <br/>
            <div class="form-group"><label class="form-label" for="name">Ime</label><input type="text" class="form-control" id="name" name="name" required /></div> <br/>
            <div class="form-group"><label class="form-label" for="surname">Priimek</label><input type="text" class="form-control" id="surname" name="surname" required /></div> <br/>
            <div class="form-group"><label class="form-label" for="address">Naslov</label><input type="text" class="form-control" id="address" name="address" /> <br/></div>
            <div class="form-group"><label class="form-label" for="zipcode">Poštna številka</label><input type="text" class="form-control" id="zipcode" name="zipcode" /></div> <br/>
            <div class="form-group"><label class="form-label" for="phone_number">Telefonska številka</label><input type="text" class="form-control" id="phone_number" name="phone_number" /></div> <br/>
            <input class="btn btn-primary" type="submit" name="submit" value="Pošlji" /> <br/>
            <label><?php echo $error; ?></label>
        </form>
    </div>
<?php
include_once('footer.php');
?>