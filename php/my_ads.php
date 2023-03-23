<?php
include_once('header.php');

function get_ads() {
    global $conn;
    $my_id = $_SESSION["USER_ID"];
    $query = "SELECT * FROM ads WHERE user_id = '$my_id' ORDER BY published DESC;";
    $res = $conn->query($query);
    $ads = array();

    while ($ad = $res->fetch_object()) {
        $ads[] = $ad;
    }

    return $ads;
}

if (isset($_COOKIE["VIEWS"])) {
    setcookie("VIEWS", "", time() - 1800);
}

include_once('get_ads_categories.php');
include_once('get_images.php');

$ads = get_ads();

include_once('show_ads.php');
include_once('footer.php');
?>
