<?php
include_once('header.php');

function validate_login($username, $password) {
	global $conn;
	$username = mysqli_real_escape_string($conn, $username);
	$pass = sha1($password);
	$query = "SELECT * FROM users WHERE username='$username' AND password='$pass'";
	$res = $conn->query($query);

    if ($user_obj = $res->fetch_object()) {
		return $user_obj;
	}
	return -1;
}

$error="";

if (isset($_POST["submit"])) {
	if (($user = validate_login($_POST["username"], $_POST["password"])) >= 0) {
		$user_id = $user->id;
		$_SESSION["USER_ID"] = $user_id;

        if ($user->admin == 1) {
			$_SESSION["ADMIN"] = true;
        }

		header("Location: index.php");
		die();
	} else {
		$error = "Prijava ni uspela.";
	}
}

?>
    <div class="container my-1">
        <br/> <h2>Prijava</h2> <br/>
        <form action="login.php" method="POST">
            <div class="form-group"><label class="form-label" for="username">Uporabniško ime</label><input type="text" class="form-control" id="username" name="username" /></div> <br/>
            <div class="form-group"><label class="form-label" for="password">Geslo</label><input type="password" class="form-control" id="password" name="password" /></div> <br/>
            <input class="btn btn-primary" type="submit" name="submit" value="Pošlji" /> <br/>
            <label><?php echo $error; ?></label>
        </form>
    </div>
<?php
include_once('footer.php');
?>