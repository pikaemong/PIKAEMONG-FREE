<?php
	// Initialize session
	session_start();
?>
<?php
	require_once("board/config/dbconfig.php");
	
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}
	
	if(isset($_GET['searchColumn'])) {
		$searchColumn = $_GET['searchColumn'];
		$subString .= '&amp;searchColumn=' . $searchColumn;
	}
	if(isset($_GET['searchText'])) {
		$searchText = $_GET['searchText'];
		$subString .= '&amp;searchText=' . $searchText;
	}
	
	if(isset($searchColumn) && isset($searchText)) {
		$searchSql = ' where ' . $searchColumn . ' like "%' . $searchText . '%"';
	} else {
		$searchSql = '';
	}

	$sql = 'select count(*) as cnt from board_free' . $searchSql;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	$allPost = $row['cnt'];
	
	if(empty($allPost)) {
		$emptyData = '<tr><td class="textCenter" colspan="5">글이 존재하지 않습니다.</td></tr>';
	} else {

		$onePage = 1000000000;
		$allPage = ceil($allPost / $onePage);
		
		if($page < 1 && $page > $allPage) {
?>
			<script>
				alert("존재하지 않는 페이지입니다.");
				history.back();
			</script>
<?php
			exit;
		}
		
		$currentLimit = ($onePage * $page) - $onePage;
		$sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage;
		
		$sql = 'select * from board_free' . $searchSql . ' order by b_no desc' . $sqlLimit;
		$result = $db->query($sql);
	}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>게시판</title>
<link rel="stylesheet" href="css/style(1).css">
</head>
<body id="tt-body-page" class="thema_aqua">
<div id="wrap" class="thema_aqua">
<div id="container">
<main id="main">
<br></br><br></br>
<div class="inner_index">
<div class="related_type related_type_view">
<ul class="list_related">
<?php
if(isset($emptyData)) {
echo $emptyData;
} else {
while($row = $result->fetch_assoc())
{
$datetime = explode(' ', $row['b_date']);
$date = $datetime[0];
$time = $datetime[1];
if($date == Date('Y-m-d'))
$row['b_date'] = $time;
else
$row['b_date'] = $date;
?>
<li>
<a class="link_related" href="./board/view.php?pikaemong=<?php echo $row['b_no']?>">
<span style="background-image:url(https://i.imgur.com/W90DDYy.png);" class="bg"></span>
<span class="txt">
<?php echo $row['b_title']?></br>
<?php echo $row['b_date']?></span>
</a>
</li> 
<?php
	}
}
?>
</ul>
</div>
</div>
<div class="btnSet">
<a href="./board/write.php" class="btnWrite btn">글쓰기</a>
</div>
</main>
</div>
</div>
</body>
</html>