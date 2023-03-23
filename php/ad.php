<?php 
include_once('header.php');

include_once('get_ad.php');
include_once('get_ads_categories.php');
include_once('get_images.php');

function increase_views($id, $views) {
	global $conn;
    $views++;

	$query = "UPDATE ads SET views = '$views' WHERE id = '$id';";

	if (!$conn->query($query)) {
		echo mysqli_error($conn);
		return false;
	}

    return true;
}

if (!isset($_GET["id"])) {
	echo "Manjkajoči parametri.";
	die();
}

$id = $_GET["id"];
$ad = get_ad($id);

if ($ad == null) {
	echo "Oglas ne obstaja.";
	die();
}

$images = get_images($ad->id);

if (!isset($_COOKIE["VIEWS"])) {
	setcookie("VIEWS", "true", time() + 1800, "/");
	increase_views($id, $ad->views);
}

?>
	<div class="container my-1">
        <br/> <h2><?php echo $ad->title;?></h2> <br/>
        <p>Kategorije: <?php echo get_ads_categories_string($ad->id);?></p>
		<p><?php echo $ad->description;?></p> <br/>
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
		<br/> <br/> <p>Objavil: <?php echo $ad->username;?></p>
        <p>Čas objave: <?php echo $ad->published;?></p>
        <p>Ogledi: <?php echo $ad->views;?></p>
		<a href="index.php"><button class="btn btn-primary">Nazaj</button></a>
        <?php if (isset($_SESSION["USER_ID"])) { if ($ad->user_id == $_SESSION["USER_ID"]) { ?>
			<a href="edit.php?id=<?php echo $id;?>"><button class="btn btn-primary">Uredi</button></a>
            <a href="delete.php?id=<?php echo $id;?>"><button class="btn btn-primary">Izbriši</button></a>
        <?php } } ?>
	</div>
<?php
include_once('footer.php');
?>