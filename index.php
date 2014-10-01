<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Roekath!</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/control.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
</head>
<body lang="en">

	<?php
	//Turn off those annoying notices
	error_reporting(E_ALL & ~E_NOTICE);
	//Load custom functions
	require('php/functions.php');
	//Open up session
	session_start();
	//Check if user is logged in
	if(checkLogin()) {
		loadGame();
	} else {
		loadHome();
	}
	//Get database connection
	//$db = dbConnect();
	$db = mysqli_connect('localhost','root','pizza','roekath');

	function loadGame() {
		echo 'GAME';
		$db = mysqli_connect('localhost','root','pizza','roekath');
		$query = mysqli_query($db,"SELECT * FROM user WHERE user='admin'");
		while($i=mysqli_fetch_array($query)) {
			$timestamp = $i['timer'];
			$maxEnergy = $i['max_energy'];
			$currentEnergy = $i['current_energy'];
			$id = $i['id'];
		}

		$currentTime = time();
		$timestamp = strtotime($timestamp);
		$timeDiff = $currentTime - $timestamp;
		$missingEnergy = $maxEnergy - $currentEnergy;
		$energyIntervals = $missingEnergy * 1200;
		$a = false;
		if($timeDiff > $energyIntervals){$a=true;}
		if($a) {
			$currentEnergy=$maxEnergy;
			$query = mysqli_query($db,"UPDATE user SET current_energy='".$currentEnergy."' WHERE id='".$id."'");
		}

		echo '<br><br>';
		echo $timestamp.'<br>';
		echo $currentTime.'<br>';
		echo $timeDiff.'<br>';
		echo $maxEnergy.'<br>';
		echo $currentEnergy.'<br>';
		echo $missingEnergy.'<br>';
		echo $energyIntervals.'<br>';
		echo $a.'<br>';
		echo '<br>';
		
		//TODO: Check current time, figure out if it is greater than $timer, do stuff
		?>
		<form action="php/logout.php" method="POST">
			<button type="submit">Logout</button>
		</form>
		<br>
		<button class="reset">Reset Timer</button><br>
		<button class="eminus" account="<?php echo $id ?>$">Minus Energy</button><br>
		<button class="ereset">Reset Energy</button><br>
		<!-- </form> -->
		<div class="timer"><?php echo '' ?></div>
		<div class="energy"><?php echo $currentEnergy.'/'.$maxEnergy ?></div>
		<?php
	}

	function loadHome() {
		echo 'HOME';
		?>
		<form action="php/login.php" method="POST">
			<button type="submit">Login</button>
		</form>
		<?php
	}

	?>
</body>
</html>