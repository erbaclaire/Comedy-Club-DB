<?php 
  session_start();
  require_once './comedy.config';

  if (!empty($_POST)) {
    if (isset( $_POST['username'] ) && isset( $_POST['password'])) {   
			$user = $_POST['username'];
			$pass = $_POST['password'];
			$myConnection = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database']);

			$query = "CALL VerifyLogin('$user','$pass')";
			$result = mysqli_query($myConnection, $query) or die ("Failed to verify login.");

			$row = mysqli_fetch_array($result);
			$verification = $row[0];

			if ($verification == 1) {
				$_SESSION['username'] = $user;
				echo "<script> window.location.assign('index.php'); </script>";
				header("Location: index.php"); 
				exit;
			}
			else {
				echo "<script type='text/javascript'>alert('Username and/or password is incorrect. Please try again.');</script>";
				echo "<script> window.location.assign('index.php'); </script>";
			}
		}
   }
?>
           
