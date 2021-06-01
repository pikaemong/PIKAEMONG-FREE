<?php
session_start();
 
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: ./login');
    exit;
}
 
require_once 'config/login.php';
 
$new_password = $confirm_password = '';
$new_password_err = $confirm_password_err = '';
 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
 
    if(empty(trim($_POST['new_password']))){
        $new_password_err = '새로운 비밀번호를 입력해주세요.';     
    } elseif(strlen(trim($_POST['new_password'])) < 6){
        $new_password_err = '비밀번호는 최소 6자 이상이어야 됩니다.';
    } else{
        $new_password = trim($_POST['new_password']);
    }
    
    if(empty(trim($_POST['confirm_password']))){
        $confirm_password_err = '비밀번호를 확인해주세요.';
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = '비밀번호가 일치 하지않습니다.';
        }
    }
        
    if(empty($new_password_err) && empty($confirm_password_err)){
        $sql = 'UPDATE users SET password = ? WHERE id = ?';
        
        if($stmt = $mysql_db->prepare($sql)){
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            $stmt->bind_param("si", $param_password, $param_id);
            
            if($stmt->execute()){
                session_destroy();
                header("location: ./login");
                exit();
            } else{
                echo "무언가 잘못되었습니다. 다시 입력 해주세요.";
            }

            $stmt->close();
        }

        $mysql_db->close();
    }
}
?>

<?php
	require_once 'config/login.php';

	$username = $password = $confirm_password = "";

	$username_err = $password_err = $confirm_password_err = "";

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (empty(trim($_POST['username']))) {
			$username_err = "아이디를 입력해주세요.";

		} else {

			$sql = 'SELECT id FROM users WHERE username = ?';

			if ($stmt = $mysql_db->prepare($sql)) {
				$param_username = trim($_POST['username']);

				$stmt->bind_param('s', $param_username);

				if ($stmt->execute()) {
					
					$stmt->store_result();

					if ($stmt->num_rows == 1) {
						$username_err = '이 아이디는 이미 사용중입니다.';
					} else {
						$username = trim($_POST['username']);
					}
				} else {
					echo "Oops! ${$username}, something went wrong. Please try again later.";
				}

				$stmt->close();
			} else {

				$mysql_db->close();
			}
		}

	    if(empty(trim($_POST["password"]))){
	        $password_err = "비밀번호를 입력해주세요.";     
	    } elseif(strlen(trim($_POST["password"])) < 6){
	        $password_err = "비밀번호는 6글자 이상 가능합니다.";
	    } else{
	        $password = trim($_POST["password"]);
	    }

	    if(empty(trim($_POST["confirm_password"]))){
	        $confirm_password_err = "비밀번호를 입력해주세요.";     
	    } else{
	        $confirm_password = trim($_POST["confirm_password"]);
	        if(empty($password_err) && ($password != $confirm_password)){
	            $confirm_password_err = "비밀번호가 일치 하지않습니다..";
	        }
	    }
	
	    if (empty($username_err) && empty($password_err) && empty($confirm_err)) {
			
			$sql = 'INSERT INTO users (username, password, ipadress) VALUES (?,?,?)';
			if ($stmt = $mysql_db->prepare($sql)) {

				$param_username = $username;
				$param_password = password_hash($password, PASSWORD_DEFAULT); // Created a password
				$param_ipadress = $_SERVER['REMOTE_ADDR'];

				// Bind param variable to prepares statement
				$stmt->bind_param('sss', $param_username, $param_password, $param_ipadress);

				if ($stmt->execute()) {
					header('location: ./login');
				} else {
					echo "Something went wrong. Try signing in again.";
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
<title>비밀번호 변경</title>
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
								<h1 class="con">비밀번호 변경</h1>
							</div>
							<div class="form-group">
								<h1 style="font-size: 15px">
									<?php echo $username_err?><?php echo $new_password_err?><?php echo $confirm_password_err?>
								</h1>
							</div>
							<div class="form-group">
								<input type="password" required=""  placeholder="새로운 비밀번호" name="new_password" id="username" class="form-control" value="<?php echo $new_password; ?>"></br>
							</div>
							<div class="form-group">
								<input type="password" required="" name="confirm_password" id="password" placeholder="비밀번호 재입력" class="form-control">
							</div>
							<input type="submit" class="btn btn-primary2 btn-lg" value="비밀번호 변경">
							<div class="form-group">
								</br><p>변경을 취소하려면, <a href="./mypage">돌아가기</a></p>
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