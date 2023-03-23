<?php
function get_images($id) {
	global $conn;
	$id = mysqli_real_escape_string($conn, $id);
	$query = "SELECT image FROM images WHERE ad_id = '$id';";
	$res = $conn->query($query);

	if ($res && $res->num_rows > 0) {
		$img = array();

		while ($obj = $res->fetch_object()) {
			$img[] = $obj->image;
		}

        return $img;
	}

	return null;
}
?>