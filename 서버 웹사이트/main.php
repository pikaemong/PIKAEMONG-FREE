<?php
	session_start();
?>
<?php require('config/config-fivem.php'); ?>
<!DOCTYPE html>
<html lang="kr-KR" class="no-js">

<head>
<?php include('main/head.php') ?>
</head>

<div>
<body onscroll="scrolled()" style="overflow: visible; height: initial;">
<div class="section fp-section fp-table" id="section0" data-anchor="introPage" style="height: 675px; padding-top: 3em; padding-bottom: 10px; background-color: rgb(204, 204, 204);">
<div class="fp-tableCell" style="height: 627px;">
<div class="particlebox">
<div id="particles-js"></div> <!--> <-->
<div class="surroundBlock">
<div class="titleblock noselect">
<img src="img/main.png">
</div>
</div>
<div class="brands">
<div>
<a class="logopart" href="<?= $fivem_url ?>">
<img src="img/sc.png"></a>
<a class="logopart" href="<?= $discord_url ?>">
<img src="img/dc.png"></a>
<a class="logopart" href="player.php">
<img src="img/spi.png"></a>
</div>
</div>
</div>
</div>
</div>

<?php
		$settings['title'] = "";
		$settings['ip'] = $ip;
		$settings['port'] = $port;
		$settings['max_slots'] = $max_slots;

		@$content = json_decode(file_get_contents("http://".$settings['ip'].":".$settings['port']."/info.json"), true);
		@$img_d64 = $content['icon'];
		if($content) {
		$gta5_players = file_get_contents("http://".$settings['ip'].":".$settings['port']."/players.json");
		$content = json_decode($gta5_players, true);
		$pl_count = count($content);
?>

<?php include('main/onstauts.php') ?>
	
	<?php } else { ?>
	<?php include('main/offstauts.php') ?>
	<?php
          } ?>
<div class="section fp-auto-height s7 fp-section fp-table" id="section7" data-anchor="Other" style="background-color: black; height: 675px; padding-top: 3em; padding-bottom: 10px;">
<div class="float-left footer-dark" style="background-color: black; width:100%;min-height:430px;bottom:0;">
<footer>
<div class="container">
<div class="row">
<div class="col-md-6 item">
<img class="rounded-circle" src="img/1msg.png">
</div>
<div class="col-sm-5 col-md-6 item nos linkFix">
<h2>테스트1</h2>
<p>테스트1-1</p>
<p>테스트1-2</p>
<p>테스트1-3</p>
<p>테스트1-4</p>
</div>
</div>
</div>
</footer>
</div>
</div>

<div class="section fp-auto-height s7 fp-section fp-table" id="section7" data-anchor="Other" style="background-color: #191970; height: 675px; padding-top: 3em; padding-bottom: 10px;">
<div class="float-left footer-dark" style="background-color: #191970; width:100%;min-height:430px;bottom:0;">
<footer>
<div class="container">
<div class="row">
<div class="col-md-6">
<h2>테스트2</h2>
<p>테스트2-1</p>
<p>테스트2-2</p>
<p>테스트2-3</p>
<p>테스트2-4</p>
</div>
<img src="img/2msg.png">
</div>
</div>
</footer>
</div>
</div>

</body>
</div>
</html>