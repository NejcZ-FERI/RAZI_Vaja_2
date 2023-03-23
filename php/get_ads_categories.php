<?php
function get_ads_categories($id) {
	global $conn;
	$id = mysqli_real_escape_string($conn, $id);
	$query = "SELECT * FROM ads_categories WHERE ads_categories.ad_id = '$id';";
	$res = $conn->query($query);

	if ($res && $res->num_rows > 0) {
		$cat = array();

		while ($obj = $res->fetch_object()) {
			$cat[] = $obj;
		}

		return $cat;
	}

	return null;
}

function get_ads_categories_string($id) {
	global $conn;
	$id = mysqli_real_escape_string($conn, $id);
	$query = "SELECT categories.title FROM categories LEFT JOIN ads_categories ON ads_categories.category_id = categories.id WHERE ads_categories.ad_id = '$id' ORDER BY categories.id ASC;";
	$res = $conn->query($query);

	if ($res && $res->num_rows > 0) {
		$cat = "";

		while ($obj = $res->fetch_object()) {
			$cat .= $obj->title. ', ';
		}

		return rtrim($cat, ', ');
	}

	return null;
}
?>