<?php
  session_start();

  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: login");
    exit;
  }

  require_once "config/login.php";

  $username = $password = '';
  $username_err = $password_err = '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(empty(trim($_POST['username']))){
      $username_err = '아이디를 입력해주세요.';
    } else{
      $username = trim($_POST['username']);
    }

    if(empty(trim($_POST['password']))){
      $password_err = '비밀번호를 입력해주세요.';
    } else{
      $password = trim($_POST['password']);
    }

    if (empty($username_err) && empty($password_err)) {
		
      $sql = 'SELECT id, username, password FROM user WHERE username = ?';

      if ($stmt = $mysql_db->prepare($sql)) {

        $param_username = $username;

        $stmt->bind_param('s', $param_username);

        if ($stmt->execute()) {

          $stmt->store_result();

          if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $hashed_password);

            if ($stmt->fetch()) {
              if (password_verify($password, $hashed_password)) {

                session_start();

                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;

                header('location: mypage');
              } else {
                $password_err = '비밀번호가 틀렸습니다. 확인후 다시 확인해주세요.';
              }
            }
          } else {
            $username_err = "아이디가 틀렸습니다. 확인후 다시 입력해주세요.";
          }
        } else {
          echo "무언가 잘못되었습니다. 다시 입력 해주세요.";
        }

        $stmt->close();
      }
	  
      $mysql_db->close();
    }
  }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<?php include_once("parts/common/head.php");?>
<title>로그인</title>
</head>
<body>

<!-- 메뉴바 -->
<?php include_once("parts/nlogin/menu.php");?>


<div class="section-container no-padding">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="row">
				</br></br></br></br></br></br></br></br></br></br>

				<section class="article-list table-common con">
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
						<div class="col-md-6 loginForm">
							<div class="form-group">
								<h1 class="con">로그인</h1>
							</div>
							<div class="form-group">
								<h1 style="font-size: 15px">
									<?php echo $username_err?><?php echo $password_err?>
								</h1>
							</div>
							<div class="form-group">
								<input  type="text" autofocus="" placeholder="아이디" name="username" id="username" class="form-control" value="<?php echo $username ?>">
							</div>
							<div class="form-group">
								<input type="password" required="" placeholder="비밀번호" name="password" id="password" class="form-control" value="<?php echo $password ?>">
							</div>
							<input type="submit" class="btn btn-primary2 btn-lg" value="로그인">
							<div class="form-group">
								</br><p>계정이 없다면, <a href="register">회원가입</a></p>
							</div>
						</div>
					</form>
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