<?php
foreach ($ads as $ad) {
	?>
	<div class="container p-4 my-5 bg-white border rounded-3">
		<h4><?php echo $ad->title;?></h4>
		<p>Kategorije: <?php echo get_ads_categories_string($ad->id);?></p>
		<img src="data:image/jpg;base64, <?php echo base64_encode(get_images($ad->id)[0]);?>" height="100" alt="slika_1" /><br/><br/>
		<a href="ad.php?id=<?php echo $ad->id;?>"><button class="btn btn-primary">Preberi več</button></a>
	</div>
	<?php
}
?>
