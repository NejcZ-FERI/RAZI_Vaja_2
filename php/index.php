<?php
include_once('header.php');

function get_ads() {
	global $conn;
	$query = "SELECT * FROM ads ORDER BY published DESC;";
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
?>

    <script>
        $(document).ready(async function() {
            await loadCommentsAll();

            if ($("#comments_section_all").is(":empty")) {
                $("#comments_all").hide();
            } else {
                $("#comments_all").show();
            }
        });

        async function loadCommentsAll() {
            await $.get("/api/index.php/comments/", renderCommentsAll);
        }

        function renderCommentsAll(comments) {
            comments.forEach(function(comment) {
                let commentsHtml = "<div class='card my-2' id='comment-" + comment.id + "'>";
                commentsHtml += "<div style='background-color: #F5FAFA' class='card-body'>";
                commentsHtml += "<h5 class='card-title'>" + comment.user.username + "</h5>";
                commentsHtml += "<p class='card-text'>" + comment.text + "</p>";
                commentsHtml += "<p>Čas objave: " + comment.published + "</p>";
                commentsHtml += "<a href='ad.php?id=" + comment.ad.id + "'><button class='btn btn-primary'>Obišči oglas</button></a>";
                commentsHtml += "</div></div>";

                $("#comments_section_all").append(commentsHtml);
            });
        }
    </script>
    <div class="container p-4 my-5 bg-white border rounded-3" id="comments_all">
        <h5 class="mb-4">Najnovejših 5 komentarjev:</h5>
        <div id="comments_section_all"></div>
    </div>

<?php
include_once('show_ads.php');
include_once('footer.php');
?>