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
	//muutujad väärtuste jaoks
	$create_username_error = $create_age_error = $create_name_error = $create_insurance_error = $create_gender_error = $create_personalcode_error = $create_password_error = "";
	//muutujad errorite joks
	$create_username = $create_age = $create_name = $create_insurance = $create_gender = $create_personalcode = $create_password = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//Kasutaja loomine
		if(isset($_POST["create"])){
			//isikukood
			if ( empty($_POST["create_personalcode"]) ) {
				$create_personalcode_error = "See väli on kohustuslik";
			}else{
				$create_personalcode = cleanInput($_POST["create_personalcode"]);
			}
			//parool
			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See väli on kohustuslik";
			} else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}
			//kasutajanimi
			if(empty($_POST["create_username"])){
				$create_username_error = "See väli on kohustuslik";
			}else{
				$create_username = cleanInput($_POST["create_username"]);
			}
			//nimi
			if(empty($_POST["create_name"])){
				$create_name_error = "See väli on kohustuslik";
			}else{
				$create_name = cleanInput($_POST["create_name"]);
			}
			//vanus
			if(empty($_POST["year"]) || empty($_POST["month"]) || empty($_POST["day"])){
				$create_age_error = "See väli on kohustuslik";
			}else{
				$create_age =  $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
			}
			//sugu
			if(empty($_POST["create_gender"])){
				$create_gender_error = "See väli on kohustuslik";
			}else{
				$create_gender = $_POST["create_gender"];
			}
			//kindlustus
			if(empty($_POST["create_insurance"])){
				$create_insurance_error = "See väli on kohustuslik";
			}else{
				$create_insurance = $_POST["create_insurance"];
			}
			
			//võib kasutaja teha
			if(	$create_personalcode_error == "" && $create_password_error == "" && $create_username_error == "" && $create_name_error == "" && $create_age_error == "" && $create_gender_error == "" && $create_insurance_error == ""){
				$password_hash = hash("sha512", $create_password);
				
				//käivitame funktsiooni
				$create_response = $User->createUser($create_personalcode, $password_hash, $create_username, $create_name, $create_age, $create_gender, $create_insurance);
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
	<title>Registreeru</title>
</head>
<body>

	<h2>Loo kasutaja</h2>
  
	<?php if(isset($create_response->error)):?>
	<p style="color:red;"><?=$create_response->error->message;?></p>
	<?php elseif(isset($create_response->success)):?>
	<p style="color:green;"><?=$create_response->success->message;?></p>
	<?php endif;?>
  
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<div class="col-md-4">
			<input name="create_username" type="text" placeholder="Kasutajanimi" value="<?php echo $create_username; ?>"> <font style="color:red">*<?php echo $create_username_error; ?></font><br><br>
			<input name="create_personalcode" type="number" placeholder="Isikukood" value="<?php echo $create_personalcode; ?>"> <font style="color:red">*<?php echo $create_personalcode_error; ?></font><br><br>
			<input name="create_password" type="password" placeholder="Parool"> <font style="color:red">*<?php echo $create_password_error; ?></font> <br><br>
			<input name="create_name" type="text" placeholder="Ees- ja perekonnanimi"> <font style="color:red">*<?php echo $create_name_error; ?></font><br><br>
		</div>
		
		<div class="col-md-8">
		<h4>Sugu *</h4><font style="color:red"><?php echo $create_gender_error; ?></font>
		<input name="create_gender" type="radio" value="m">Mees
		<input name="create_gender" type="radio" value="f">Naine<br>
		<h4>Sünnikuupäev *</h4><font style="color:red"><?php echo $create_age_error; ?></font>
			<select name="day">
			<option value="">Päev</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
			<option value="24">24</option>
			<option value="25">25</option>
			<option value="26">26</option>
			<option value="27">27</option>
			<option value="28">28</option>
			<option value="29">29</option>
			<option value="30">30</option>
			<option value="31">31</option>
		</select>
		<select name="month">
			<option value="">Kuu</option>
			<option value="1">Jaanuar</option>
			<option value="2">Veebruar</option>
			<option value="3">Märts</option>
			<option value="4">Aprill</option>
			<option value="5">Mai</option>
			<option value="6">Juuni</option>
			<option value="7">Juuli</option>
			<option value="8">August</option>
			<option value="9">September</option>
			<option value="10">Oktoober</option>
			<option value="11">November</option>
			<option value="12">Detsember</option>
		</select>
		 <select name="year">
			<option value="">Aasta</option>
			<option value="2015">2015</option>
			<option value="2014">2014</option>
			<option value="2013">2013</option>
			<option value="2012">2012</option>
			<option value="2011">2011</option>
			<option value="2010">2010</option>
			<option value="2009">2009</option>
			<option value="2008">2008</option>
			<option value="2007">2007</option>
			<option value="2006">2006</option>
			<option value="2005">2005</option>
			<option value="2004">2004</option>
			<option value="2003">2003</option>
			<option value="2002">2002</option>
			<option value="2001">2001</option>
			<option value="2000">2000</option>
			<option value="1999">1999</option>
			<option value="1998">1998</option>
			<option value="1997">1997</option>
			<option value="1996">1996</option>
			<option value="1995">1995</option>
			<option value="1994">1994</option>
			<option value="1993">1993</option>
			<option value="1992">1992</option>
			<option value="1991">1991</option>
			<option value="1990">1990</option>
			<option value="1989">1989</option>
			<option value="1988">1988</option>
			<option value="1987">1987</option>
			<option value="1986">1986</option>
			<option value="1985">1985</option>
			<option value="1984">1984</option>
			<option value="1983">1983</option>
			<option value="1982">1982</option>
			<option value="1981">1981</option>
			<option value="1980">1980</option>
			<option value="1979">1979</option>
			<option value="1978">1978</option>
			<option value="1977">1977</option>
			<option value="1976">1976</option>
			<option value="1975">1975</option>
			<option value="1974">1974</option>
			<option value="1973">1973</option>
			<option value="1972">1972</option>
			<option value="1971">1971</option>
			<option value="1970">1970</option>
			<option value="1969">1969</option>
			<option value="1968">1968</option>
			<option value="1967">1967</option>
			<option value="1966">1966</option>
			<option value="1965">1965</option>
			<option value="1964">1964</option>
			<option value="1963">1963</option>
			<option value="1962">1962</option>
			<option value="1961">1961</option>
			<option value="1960">1960</option>
			<option value="1959">1959</option>
			<option value="1958">1958</option>
			<option value="1957">1957</option>
			<option value="1956">1956</option>
			<option value="1955">1955</option>
			<option value="1954">1954</option>
			<option value="1953">1953</option>
			<option value="1952">1952</option>
			<option value="1951">1951</option>
			<option value="1950">1950</option>
			<option value="1949">1949</option>
			<option value="1948">1948</option>
			<option value="1947">1947</option>
			<option value="1946">1946</option>
			<option value="1945">1945</option>
			<option value="1944">1944</option>
			<option value="1943">1943</option>
			<option value="1942">1942</option>
			<option value="1941">1941</option>
			<option value="1940">1940</option>
			<option value="1939">1939</option>
			<option value="1938">1938</option>
			<option value="1937">1937</option>
			<option value="1936">1936</option>
			<option value="1935">1935</option>
			<option value="1934">1934</option>
			<option value="1933">1933</option>
			<option value="1932">1932</option>
			<option value="1931">1931</option>
			<option value="1930">1930</option>
			<option value="1929">1929</option>
			<option value="1928">1928</option>
			<option value="1927">1927</option>
			<option value="1926">1926</option>
			<option value="1925">1925</option>
			<option value="1924">1924</option>
			<option value="1923">1923</option>
			<option value="1922">1922</option>
			<option value="1921">1921</option>
			<option value="1920">1920</option>
		</select>
		<h4>Kas ravikindlustus on olemas? * </h4><font style="color:red"><?php echo $create_insurance_error; ?></font>
		<input name="create_insurance" type="radio" value="1">jah
		<input name="create_insurance" type="radio" value="0">ei<br><br><br>
		</div>
		<input type="submit" name="create" value="Loo kasutaja">
	</form>
</body>
</html>