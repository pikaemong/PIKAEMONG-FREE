<?php
	session_start();
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<?php include_once("parts/common/head.php");?>
<title>마이페이지</title>
<style>
table.type07 {
  border-collapse: collapse;
  text-align: left;
  line-height: 1.5;
  border: 1px solid #ccc;
  margin: 20px 10px;
}
table.type07 thead {
  border-right: 1px solid #ccc;
  border-left: 1px solid #ccc;
  background: #e7708d;
}
table.type07 thead th {
  padding: 10px;
  font-weight: bold;
  vertical-align: top;
  color: #fff;
}
table.type07 tbody th {
  width: 150px;
  padding: 10px;
  font-weight: bold;
  vertical-align: top;
  border-bottom: 1px solid #ccc;
  background: #fcf1f4;
}
table.type07 td {
  width: 350px;
  padding: 10px;
  vertical-align: top;
  border-bottom: 1px solid #ccc;
}
</style>
</head>
<body>

<!-- 메뉴바 -->
<?php include_once("parts/ylogin/menu.php");?>

<div class="section-container no-padding">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="row">
				</br></br></br></br></br></br>
				<h1 class="con">내정보</h1>
				</br>
					</br>
					<section class="article-list table-common con mypageForm">
						<table border="1">
							<thead>
								<tr>
									<th>고유번호</th>
									<th>지갑</th>
									<th>은행</th>
									<th>크레딧</th>
								</tr>
							</thead>

							<tbody>
								<tr>
<?php require_once "config/user_moneys.php";?>
									<td><?php echo @$row['user_id'];?></td>
									<td><?php echo @$row['wallet'];?>원</td>
									<td><?php echo @$row['bank'];?>원</td>
									<td><?php echo @$row['credit'];?>원</td>
								</tr>
							</tbody>
						</table>
						<table border="1">
							<thead>
								<tr>
									<th>차량번호</th>
									<th>전화번호</th>
									<th>이름</th>
									<th>나이</th>
								</tr>
							</thead>

							<tbody>
								<tr>
<?php require_once "config/user_identities.php";?>
									<td><?php echo @$row['registration'];?></td>
									<td><?php echo @$row['phone'];?></td>
									<td><?php echo "".@$row['firstname']."".@$row['name']."";?></td>
									<td><?php echo @$row['age'];?></td>
								</tr>
							</tbody>
						</table>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- script 연결 -->
<?php include_once("parts/common/script.php");?>
</body>
</html>

<?php
	} else {
		header("location: ./login");
}
?>