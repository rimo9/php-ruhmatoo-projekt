<?php
//laeme funktsiooni failis
	require_once("functions.php");
	
	//*******************//
	//***Kuhu suunata?***//
	//*******************//
	//kontrollin, kas kasutaja on sisseloginud
	if(isset($_SESSION["id_from_db"])){
		// kui on,suunan data lehele
		header("Location: data.php");
		exit();
	}
	
	// muuutujad errorite jaoks
	$personalcode_error = $password_error = $gender_error = $insurance_error = $name_error = $age_error = $username_error = "";
	// muutujad väärtuste jaoks
	$personalcode = $password = $gender = $insurance = $name = $age = $username = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		// Sisse logimine
		if(isset($_POST["login"])){
			//isikukood
			if(empty($_POST["personalcode"])){
				$personalcode_error = "See väli on kohustuslik";
			}else{
				// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$personalcode = cleanInput($_POST["personalcode"]);
			}
			//parool
			if(empty($_POST["password"])){
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			//sugu
			if(empty($_POST["gender"])){
				$gender_error = "See väli on kohustuslik";
			}
			//kasutajanimi
			if(empty($_POST["username"])){
				$username_error = "See väli on kohustuslik";
			}else{
				$username = cleanInput($_POST["username"]);
			}
			//kindlustus
			if(empty($_POST["insurance"])){
				$insurance_error = "See väli on kohustuslik";
			}
			//nimi
			if(empty($_POST["name"])){
				$name_error = "See väli on kohustuslik";
			}else{
				$name = cleanInput($_POST["name"]);
			}
			//vanus
			if(empty($_POST["age"])){
				$age_error = "See väli on kohustuslik";
			}else{
				$age = cleanInput($_POST["age"]);
			}
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $personalcode_error == "" && $gender_error == "" && $insurance_error == "" && $name_error == "" && $age_error == ""){

				$password_hash = hash("sha512", $password);
				
				// käivitan funktsiooni
				$login_response = $User->loginUser($username, $password_hash);
				if(isset($login_response->success)){
					//läks edukalt, peab sessiooni salvestama
					$_SESSION["id_from_db"] = $login_response->success->user->id;
					$_SESSION["un_from_db"] = $login_response->success->user->username;
					//***********************************//
					//**suunamine peale sisse logimist?**//
					//***********************************//
					header("Location:data.php");
					//lõpetame php laadimise
					exit();
				}
			}
		}
	}
  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
?>

<?php
	//load header
	require_once("header.php");
?> 
<!--main code start here --> 

<html>
<head>
  <title>Logi sisse</title>
</head>
<body>

  <h2>Logi sisse</h2>
  
  <?php if(isset($login_response->error)):?>
  <p style="color:red;"><?=$login_response->error->message;?></p>
  <?php elseif(isset($login_response->success)):?>
  <p style="color:green;"><?=$login_response->success->message;?></p>
  <?php endif;?>
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="username" type="text" placeholder="Kasutajanimi" value="<?php echo $username; ?>"> <?php echo $username_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Logi sisse">
  </form>

</body>
</html>

<!--main code end here -->  
<?php
	//load footer
	require_once("footer.php");	
?> 
    