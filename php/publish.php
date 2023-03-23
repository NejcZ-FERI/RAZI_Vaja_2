<?php
include_once('header.php');

function publish($title, $desc, $img, $cat) {
	global $conn;
	$title = mysqli_real_escape_string($conn, $title);
	$desc = mysqli_real_escape_string($conn, $desc);
	$user_id = $_SESSION["USER_ID"];
	
	$query = "INSERT INTO ads (title, description, views, user_id, published)
                VALUES('$title', '$desc', 0, '$user_id', NOW());";

    if ($conn->query($query)) {
        $ad_id = mysqli_insert_id($conn);

        if ($ad_id) {
            foreach ($cat as $c) {
				$query = "INSERT INTO ads_categories (ad_id, category_id)
                            VALUES('$ad_id', '$c');";

				if (!$conn->query($query)) {
					echo mysqli_error($conn);
					return false;
				}
			}

			for ($i = 0; $i < count($img["tmp_name"]); $i++) {
				$img_file = file_get_contents($img["tmp_name"][$i]);
				$img_file = mysqli_real_escape_string($conn, $img_file);

				$query = "INSERT INTO images (ad_id, image)
                            VALUES('$ad_id', '$img_file');";

				if (!$conn->query($query)) {
					echo mysqli_error($conn);
					return false;
				}
            }

            return true;
        } else {
            echo "Error: Failed to get ID of new ad";
            return false;
        }
	} else {
		echo mysqli_error($conn);
		return false;
	}
}

include_once('get_categories.php');

$categories = get_categories();
$error = "";

if (isset($_POST["submit"])) {
	if (empty($_POST['categories'])) {
		$error = 'Izbrati morate vsaj 1 kategorijo.';
	} else {
		if (publish($_POST["title"], $_POST["description"], $_FILES["images"], $_POST["categories"])) {
			header("Location: index.php");
			die();
		} else {
			$error = "Prišlo je do našpake pri objavi oglasa.";
		}
	}
}

?>
    <div class="container my-1">
        <br/> <h2>Objavi oglas</h2> <br/>
        <form action="publish.php" method="POST" enctype="multipart/form-data">
            <div class="form-group"><label class="form-label" for="title">Naslov</label><input type="text" class="form-control" id="title" name="title" required /></div> <br/>
            <div class="form-group"><label class="form-label" for="description">Vsebina</label><textarea id="description" class="form-control" name="description" rows="10" cols="50" required></textarea></div> <br/>
            <div class="form-group">
                <label class="form-check-label">Kategorije</label> <br/>
                <?php foreach ($categories as $cat) { ?>
                    <label class="form-check-label" for="category_<?php echo $cat->id;?>"><?php echo $cat->title;?></label>
                    <input type="checkbox" class="form-check-input" id="category_<?php echo $cat->id;?>" name="categories[]" value="<?php echo $cat->id;?>" > <br/>
                <?php } ?>
            </div> <br/>
            <div class="form-group"><label class="form-label" for="image">Slike</label><br/><input type="file" class="form-control" id="image formFile" name="images[]" accept="image/png,image/jpeg" multiple required /></div> <br/>
            <input class="btn btn-primary" type="submit" name="submit" value="Objavi" /> <br/>
            <label><?php echo $error; ?></label>
        </form>
    </div>
<?php
include_once('footer.php');
?>