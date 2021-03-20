<?php
	require_once("config/dbconfig.php");
	$bNo = $_GET['pikaemong'];

	if(!empty($bNo) && empty($_COOKIE['board_free_' . $bNo])) {
		$sql = 'update board_free set b_hit = b_hit + 1 where b_no = ' . $bNo;
		$result = $db->query($sql); 
		if(empty($result)) {
			?>
			<script>
				alert('오류가 발생했습니다.');
				history.back();
			</script>
			<?php 
		} else {
			setcookie('board_free_' . $bNo, TRUE, time() + (60 * 60 * 24), '/');
		}
	}
	
	$sql = 'select b_title, b_content, b_date, b_hit, b_id from board_free where b_no = ' . $bNo;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<?php include('main/head.php') ?>
<div id="scrollbar" class="scrollbar">
<body class="home-page bp-nouveau home blog wpf-dark wpft- no-js">

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<article id="post-1431" class="card content panel post-1431 post type-post status-publish format-standard sticky hentry category-uncategorized">
			<div class="card-content">
				<div class="card-title">
					<a rel="bookmark">제목: <?php echo $row['b_title']?></a>
					<p class="info"></p>
				</div>
				<p><span style="color: #00ccff;"><strong>
				<span id="boardID">작성자: <?php echo $row['b_id']?></br></span>
				<span id="boardDate">작성일: <?php echo $row['b_date']?></br></span>
				<span id="boardHit">조회: <?php echo $row['b_hit']?></br></span></strong>
				</span>
				<div id="boardContent"></br><?php echo $row['b_content']?></div>

				</p>
				<p><a href="../test.php">목록</a></p>
			</div>
		</article>		
	</main>
</div>
</body>
</div>
</html>