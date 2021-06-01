<?php
	session_start();
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	header("location: ./login");
    exit;
  }
?>

<?php
	// Include config file
	require_once 'config/login.php';


	// Define variables and initialize with empty values
	$username = $password = $confirm_password = "";

	$username_err = $password_err = $confirm_password_err = "";

	// Process submitted form data
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		// Check if username is empty
		if (empty(trim($_POST['username']))) {
			$username_err = "아이디를 입력해주세요.";

			// Check if username already exist
		} else {

			// Prepare a select statement
			$sql = 'SELECT id FROM user WHERE username = ?';

			if ($stmt = $mysql_db->prepare($sql)) {
				// Set parmater
				$param_username = trim($_POST['username']);

				// Bind param variable to prepares statement
				$stmt->bind_param('s', $param_username);

				// Attempt to execute statement
				if ($stmt->execute()) {
					
					// Store executed result
					$stmt->store_result();

					if ($stmt->num_rows == 1) {
						$username_err = '이 아이디는 이미 사용중입니다.';
					} else {
						$username = trim($_POST['username']);
					}
				} else {
					echo "Oops! ${$username}, something went wrong. Please try again later.";
				}

				// Close statement
				$stmt->close();
			} else {

				// Close db connction
				$mysql_db->close();
			}
		}

		// Validate password
	    if(empty(trim($_POST["password"]))){
	        $password_err = "비밀번호를 입력해주세요.";     
	    } elseif(strlen(trim($_POST["password"])) < 6){
	        $password_err = "비밀번호는 6글자 이상 가능합니다.";
	    } else{
	        $password = trim($_POST["password"]);
	    }
    
	    // Validate confirm password
	    if(empty(trim($_POST["confirm_password"]))){
	        $confirm_password_err = "비밀번호를 입력해주세요.";     
	    } else{
	        $confirm_password = trim($_POST["confirm_password"]);
	        if(empty($password_err) && ($password != $confirm_password)){
	            $confirm_password_err = "비밀번호가 일치 하지않습니다..";
	        }
	    }

	    // Check input error before inserting into database
			
	    if (empty($username_err) && empty($password_err) && empty($confirm_err)) {
			
	    	// Prepare insert statement
			$sql = 'INSERT INTO user (username, user_id, password, ipadress) VALUES (?,?,?,?)';
			if ($stmt = $mysql_db->prepare($sql)) {

				// Set parmater
				$param_user_id = trim($_POST["user_id"]);
				$param_username = $username;
				$param_password = password_hash($password, PASSWORD_DEFAULT); // Created a password
				$param_ipadress = $_SERVER['REMOTE_ADDR'];

				// Bind param variable to prepares statement
				$stmt->bind_param('ssss', $param_username, $param_user_id, $param_password, $param_ipadress);

				// Attempt to execute
				if ($stmt->execute()) {
					// Redirect to login page
					header('location: ./login');
					// echo "Will  redirect to login page";
				} else {
					echo "Something went wrong. Try signing in again.";
				}

				// Close statement
				$stmt->close();	
			}

			// Close connection
			$mysql_db->close();
	    }
	}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<?php include_once("parts/common/head.php");?>
<title>회원가입</title>
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
								<h1 class="con">회원가입</h1>
								<a class="con">가입시 개인정보를 수집합니다.</a>
							</div>
							<div class="form-group">
								<h1 style="font-size: 15px">
									<?php echo $username_err?><?php echo $password_err?><?php echo $confirm_password_err?>
								</h1>
							</div>
							<div class="form-group">
								<input type="text" required="" placeholder="아이디" name="username" id="username" class="form-control" value="<?php echo $username ?>">
							</div>
							<div class="form-group">
								<input type="text" required="" placeholder="고유번호" name="user_id" id="user_id" class="form-control">
							</div>
							<div class="form-group">
								<input type="password" required="" name="password" id="password" placeholder="비밀번호" class="form-control" value="<?php echo $password ?>">
							</div>
							<div class="form-group">
								<input type="password" required="" name="confirm_password" id="confirm_password" placeholder="비밀번호 확인" class="form-control" value="<?php echo $confirm_password; ?>">
							</div>
							<input type="submit" class="btn btn-primary2 btn-lg" value="이용약관 동의 후 회원가입">
							<div class="form-group">
								</br><p>이미 가입 된 계정이 있다면, <a href="./login">로그인</a></p>
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