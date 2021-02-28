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
<body onscroll="scrolled()" class="fp-viewing-softwareProgramming" style="overflow: visible; height: initial;">
<?php
		$settings['title'] = "";
		$settings['ip'] = $ip;
		$settings['port'] = $port;
		$settings['max_slots'] = $max_slots;

		@$content = json_decode(file_get_contents("http://".$settings['ip'].":".$settings['port']."/info.json"), true);
		@$img_d64 = $content['icon'];
		if($content) {
		$gta5_players = file_get_contents("http://".$settings['ip'].":".$settings['port']."/players.json");
		$gta5_players1 = file_get_contents("http://".$settings['ip'].":".$settings['port']."/players.json");
		$content = json_decode($gta5_players, true);
		$content1 = json_decode($gta5_players1, false);
		$pl_count = count($content);
?>
<div id="load_tweets">
<div class="section fp-auto-height s7 fp-section fp-table" id="section7" data-anchor="Other" style="background-color: ORANGE; height: 675px; padding-top: 3em; padding-bottom: 10px;">
<div class="float-left footer-dark" style="background-color: ORANGE; width:100%;min-height:430px;bottom:0;">
<footer>
<div class="container">
<div class="row">
<div class="col-md-6 item text">
<h1>서버상태: 온라인</h1>
<p>최대인원: <?= $settings['max_slots'] ?>명</p>
<p>현재인원: <?= $pl_count ?>명 </p>
<p>60초 마다 새로고침</p>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
{
$('#load_tweets').load('player.php').fadeIn("slow");
}, 60000); // 새로고침  1000은 1초를 의미
</script>


<?php
  for ($i=0; $i <count($content) ; $i++) {
  ?>
  <tr>
    <th><?php echo $content[$i]["id"]; ?></th>
    <th><?php echo $content[$i]["name"]; ?></th>
    <th><?php echo $content[$i]["ping"]; ?></br></th>
  </tr>
  <?php
  }

  ?>
</div>
</div>
</div>
</div>
</footer>
</div>
</div>
	
	<?php } else { ?>
		<h1>서버상태: 오프라인</h1>
	<?php
          } ?>
</body>
</div>
</html>