<?php
include_once('header.php');

if (!isset($_GET["id"])) {
	echo "Manjkajoči parametri!";
	die();
}

if (!isset($_SESSION["USER_ID"])) {
	echo "Niste prijavljeni!";
	die();
}

$id = $_GET["id"];
$my_id = $_SESSION["USER_ID"];
global $conn;
$id = mysqli_real_escape_string($conn, $id);
$query = "SELECT * FROM ads WHERE ads.id = '$id';";
$res = $conn->query($query);

if ($obj = $res->fetch_object()) {
	if ($obj->user_id == $my_id) {
		$query = "DELETE FROM ads WHERE id = '$id';
					DELETE FROM ads_categories WHERE ad_id = '$id';
					DELETE FROM images WHERE ad_id = '$id';";

		if ($conn->multi_query($query)) {
			header("Location: index.php");
		} else {
			echo mysqli_error($conn);
		}
	} else {
		echo "Oglas ni vaš.";
	}
} else {
	echo "Oglas ne obstaja.";
}

include_once('footer.php');
?>
