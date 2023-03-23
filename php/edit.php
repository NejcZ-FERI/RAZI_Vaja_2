<?php
include_once('header.php');

function edit($id, $title, $desc, $img, $cat, $del) {
	global $conn;
	$title = mysqli_real_escape_string($conn, $title);
	$desc = mysqli_real_escape_string($conn, $desc);

    if ($del) {
        $query = "DELETE FROM images WHERE ad_id = '$id';";

        if (!$conn->query($query)) {
            echo mysqli_error($conn);
            return false;
        }
    }

	$query = "UPDATE ads SET title = '$title', description = '$desc', published = NOW() WHERE id = '$id';";

	if ($conn->query($query)) {
        $query = "DELETE FROM ads_categories WHERE ad_id = '$id';";

        if ($conn->multi_query($query)) {
            foreach ($cat as $c) {
                $query = "INSERT INTO ads_categories (ad_id, category_id)
                        VALUES('$id', '$c');";

                if (!$conn->query($query)) {
                    echo mysqli_error($conn);
                    return false;
                }
            }

            foreach ($img["tmp_name"] as $key => $tmp_name) {
                if (!empty($img["tmp_name"][$key])) {
					$img_file = file_get_contents($img["tmp_name"][$key]);
					$img_file = mysqli_real_escape_string($conn, $img_file);

					$query = "INSERT INTO images (ad_id, image)
                    VALUES('$id', '$img_file');";

					if (!$conn->query($query)) {
						echo mysqli_error($conn);
						return false;
					}
				}
            }

            header("Location: index.php");
            return true;
        } else {
            echo mysqli_error($conn);
            return false;
        }
	} else {
		echo mysqli_error($conn);
		return false;
	}
}

include_once('get_ad.php');
include_once('get_categories.php');
include_once('get_ads_categories.php');
include_once('get_images.php');

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
$ad = get_ad($id);
$categories = get_categories();
$ad_categories = get_ads_categories($id);
$images = get_images($id);
$error = "";

if (isset($_POST["submit"])) {
	if (empty($_POST['categories'])) {
		$error = 'Izbrati morate vsaj 1 kategorijo.';
	} else if (isset($_POST["delete"]) && empty($_FILES["images"]["tmp_name"][0])) {
		$error = 'Izbrati morate vsaj 1 sliko.';
    } else {
		if (edit($id, $_POST["title"], $_POST["description"], $_FILES["images"], $_POST["categories"], isset($_POST["delete"]))) {
			header("Location: index.php");
			die();
		} else {
			$error = "Prišlo je do našpake pri objavi oglasa.";
		}
	}
}

?>
    <div class="container my-1">
        <br/> <h2>Uredi oglas</h2> <br/>
        <form action="edit.php?id=<?php echo $id;?>" method="POST" enctype="multipart/form-data">
            <div class="form-group"><label class="form-label" for="title">Naslov</label><input type="text" class="form-control" id="title" name="title" value="<?php echo $ad->title;?>" required /></div> <br/>
            <div class="form-group"><label class="form-label" for="description">Vsebina</label><textarea id="description" class="form-control" name="description" rows="10" cols="50" required><?php echo $ad->description;?></textarea></div> <br/>
            <div class="form-group">
            <label class="form-check-label">Kategorije</label> <br/>
                <?php foreach ($categories as $cat) { ?>
                    <label class="form-check-label" for="category_<?php echo $cat->id;?>"><?php echo $cat->title;?></label>
                    <input type="checkbox" class="form-check-input" id="category_<?php echo $cat->id;?>" name="categories[]" value="<?php echo $cat->id;?>" <?php if (in_array($cat->id, array_column($ad_categories, 'category_id'))) echo "checked";?> > <br/>
                <?php } ?>
            </div> <br/>
            <div class="form-group"><label class="form-label" for="image">Slika </label><br/><input type="file" class="form-control" id="image formFile" name="images[]" accept="image/png,image/jpeg" multiple /></div> <br/> <br/>
            <?php
            if (!empty($images)) {
                $i = 1;
                foreach ($images as $img) { ?>
                    <img src="data:image/jpg;base64, <?php echo base64_encode($img);?>" height="300" alt="slika_<?php echo $i;?>" />
                    <?php
                    $i++;
                }
            }
            ?>
            <br/> <br/> <div class="form-group"><label class="form-check-label" for="delete">Izbriši slike</label> <input type="checkbox" class="form-check-input" id="delete" name="delete" value="true"></div> <br/>
            <input class="btn btn-primary" type="submit" name="submit" value="Uredi" /> <br/>
            <label><?php echo $error; ?></label>
        </form>
    </div>
<?php
include_once('footer.php');
?>
