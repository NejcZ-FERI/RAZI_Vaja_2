<?php
function get_categories() {
    global $conn;
    $query = "SELECT * FROM categories;";
    $res = $conn->query($query);
    $categories = array();

    while ($cat = $res->fetch_object()) {
        $categories[] = $cat;
    }

    return $categories;
}
?>