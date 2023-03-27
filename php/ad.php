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
    <script>
        $(document).ready(async function() {
            await loadComments();
            checkCommentsSectionEmpty();
            $("#create_comment_btn").click(createComment);
            //$(".delete_comment_btn").click(deleteClickHandler);
            $("#comments_section").on("click", ".delete_comment_btn", deleteClickHandler);

            const observer = new MutationObserver((mutationsList, observer) => { checkCommentsSectionEmpty(); });

            observer.observe(document.getElementById('comments_section'), {attributes: false, childList: true, subtree: true});
        });

        function checkCommentsSectionEmpty() {
            if ($("#comments_section").is(":empty")) {
                $("#comment_div").hide();
            } else {
                $("#comment_div").show();
            }
        }

        async function loadComments() {
            await $.get("/api/index.php/comments/<?php echo $id;?>", renderComments);
        }

        function renderComments(comments) {
            comments.forEach(function(comment) {
                $.get('http://ip-api.com/json/' + comment.user_ip + '?fields=1', function(ip) {
                    let commentsHtml = "<div class='card my-2' id='comment-" + comment.id + "'>";
                    commentsHtml += "<div class='card-body'>";
                    commentsHtml += "<h5 class='card-title'>" + comment.user.username + "</h5>";
                    commentsHtml += "<p class='card-text'>" + ip.country + "</p>";
                    commentsHtml += "<p class='card-text'>" + comment.text + "</p>";
                    commentsHtml += "<p class='card-text'>Čas objave: " + comment.published + "</p>";

                    <?php if (isset($_SESSION['USER_ID']) && (($ad->user_id == $_SESSION['USER_ID']) || (isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]))) { ?>
                    commentsHtml += "<button class='btn btn-danger delete_comment_btn' data-comment-id='" + comment.id + "'>Delete</button>";
                    <?php } ?>

                    commentsHtml += "</div></div>";

                    $("#comments_section").append(commentsHtml);
                });
            });
        }

        function createComment() {
            if ($("#create_comment_text").val().trim() === "") {
                return false;
            } else {
                $.getJSON("http://ip-api.com/json/?callback=?", function(user_ip) {
                    let data = {
                        ad_id: <?php echo $ad->id; ?>,
                        user_ip: user_ip.query,
                        text: $("#create_comment_text").val()
                    };

                    $("#create_comment_text").val("");

                    $.post('/api/index.php/comments/', data, function(data) {
                        $.get('http://ip-api.com/json/' + data.user_ip + '?fields=1', function(ip) {
                            let commentsHtml = "<div class='card my-2' id='comment-" + data.id + "'>";
                            commentsHtml += "<div class='card-body'>";
                            commentsHtml += "<h5 class='card-title'>" + data.user.username + "</h5>";
                            commentsHtml += "<p class='card-text'>" + ip.country + "</p>";
                            commentsHtml += "<p class='card-text'>" + data.text + "</p>";
                            commentsHtml += "<p class='card-text'>Čas objave: " + data.published + "</p>";

                            <?php if (isset($_SESSION['USER_ID']) && (($ad->user_id == $_SESSION['USER_ID']) || (isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]))) { ?>
                            commentsHtml += "<button class='btn btn-danger delete_comment_btn' data-comment-id='" + data.id + "'>Delete</button>";
                            <?php } ?>

                            commentsHtml += "</div></div>";

                            $("#comments_section").prepend(commentsHtml);
                        });
                    });
                });
            }
        }

        function deleteClickHandler() {
            let id = $(this).data("comment-id");
            deleteComment(id);
            let row = $("#comment-" + id);
            row.remove();
        }

        function deleteComment(id) {
            $.ajax({method: 'DELETE', url: '/api/index.php/comments/' + <?php echo $id; ?> + '/' + id});
        }
    </script>

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
        <?php } ?>
            <br/> <br/> <hr/> <br/> <div class="form-group">
                <label class="form-label" for="create_comment_text">Komentiraj</label>
                <textarea class="form-control" id="create_comment_text" name="create_comment_text" rows="6" cols="50"></textarea>
            </div>
            <br/> <div class="form-group">
                <button id="create_comment_btn" class="btn btn-primary btn-block">Dodaj</button>
            </div>
		<?php } ?>
        <div id="comment_div">
            <br/> <hr/> <br/> <h5 class="mb-4" id="comment_title">Komentarji:</h5>
            <div id="comments_section"></div>
        </div>
    </div>
<?php
include_once('footer.php');
?>