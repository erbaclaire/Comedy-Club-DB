<!DOCTYPE html>
<html>
	<head>
		
		<title>Project CCDB</title>
		<?php include('faviconInfo.php'); ?>
		<link rel="stylesheet" href="css/explore_venues_performers_css.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">

	</head>

	<body> 

	<div class="split left" style="padding-left:1%; padding-right: 1%">

	    <?php 
			//connect
			require_once './comedy.config';

			//connect to database
			$dbcon = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database'])
			or die('Could not connect: ' . mysqli_connect_error());

			//get input
			$VEN = $_REQUEST['Venue'];

			//find info about performer
			$query = "CALL GetVenueInfoBasic(".$VEN.")";
			$result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
			$venue = mysqli_fetch_row($result);

			if ($venue[1] == NULL || $venue[1] == '') { $des = ''; } else { $des = "<p><b>Venue Description: </b><br/>".$venue[1]."</p>"; }
			if ($venue[2] == NULL || $venue[2] == '' || $venue[2] == '0') { $cap = ''; } else { $cap = "<p><b>Capacity: </b>".$venue[2]."</p>"; }
			if ($venue[3] == NULL || $venue[3] == '' || $venue[3] == '0') { $fy = ''; } else { $fy = "<p><b>Year Founded: </b>".$venue[3]."</p>"; }
			if ($venue[4] == NULL || $venue[4] == '') { $venuenameurl = "<h2>".$venue[0]."</h2>"; } else { $venuenameurl = "<h2><a href='".$venue[4]."' target='_blank'><font color='blue'>".$venue[0]."</font></a></h2>"; }
			if ($venue[5] == NULL || $venue[5] == '') { $photo = 'http://www.clker.com/cliparts/B/P/m/R/W/l/building-greyscale-md.png'; } else { $photo = $venue[5]; }
			//if ($venue[11] == NULL) { $drink = ''; } elseif ($venue[11] == 1) { $drink = "<p><b>Two Drink Minimum: </b>Yes</p>"; } else { $drink = "<p><b>Two Drink Minimum: </b>No</p>"; }
			//if ($venue[12] == NULL) { $item = ''; } elseif ($venue[12] == 1) { $item = "<p><b>Two Item Minimum: </b>Yes</p>"; } else { $item = "<p><b>Two Item Minimum: </b>No</p>"; }
			if ($venue[11] == 1) {$drinkitem = "<p><b>Two Drink Minimum</b></p>"; } elseif ($venue[12] == 1) {$drinkitem = "<p><b>Two Item Minimum</b></p>"; } else { $drinkitem = " "; }

			//print info about venue
	    	echo '<img src="'.$photo.'" alt="Profile Pic">'.
					$venuenameurl.
				  //<h2>'.$venue[0].'</h2>
				  '<h3>'.$venue[7].'<br/>'.$venue[8].', '.$venue[9].' '.$venue[10].'<br/>'.$venue[6].'</h3>'.
				  //<h3>'.$web.'</h3>'.
				  //$drink.
				  //$item.
				  $drinkitem.
				  $cap.
				  $fy.
				  $des.'';

            mysqli_free_result($result);
            mysqli_close($dbcon); 

			
	    ?>
	    <br>
		<?php

		//connect
			require_once './comedy.config';

			//connect to database
			$dbcon = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database'])
			or die('Could not connect: ' . mysqli_connect_error());

		//get input
			$VEN = $_REQUEST['Venue'];
		//find info about performer
			$query = "CALL GetVenueGenderInfo(".$VEN.")";
			$result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
			$venue = mysqli_fetch_row($result);

			echo '<div><b>Total Bookings (Sep-Nov 2019):</b> '.$venue[0].'</div>
				<div><b>Breakdown:</b></div>
				<div><b>Male:</b> '.$venue[1].'</div>
				<div><b>Female:</b> '.$venue[2].'</div>
				<div><b>Non-binary:</b> '.$venue[3].'</div>';
			
			mysqli_free_result($result);
            mysqli_close($dbcon); 
			?>
	</div>

	<div class="split right">
		<div class="topnav">
			<a href="index.php">Home</a>
		</div>
	      <div align="center">
			  <h1>Performances</h1>
		  </div>
	  	  <?php 
			//connect
			require_once './comedy.config';

			//connect to database
			$dbcon = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database'])
			or die('Could not connect: ' . mysqli_connect_error());

			//get input
			$VEN = $_REQUEST['Venue'];

			//find info about venue
			$query = "CALL GetVenueBookingInfo(".$VEN.")";
			$result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
			
			//set default timezone
			date_default_timezone_set('US/Eastern');

			//get future performance data
			echo "<div>
				  <hr><h2>Upcoming Shows</h2><hr>";
		    $past_date = '';
		    $counter = 0;
			while ($performance = mysqli_fetch_array($result)) {
				if ($performance['performancedate'] >= date('Y-m-d') && $performance['performancedate'] != NULL) {		
					if ($performance['bookingtypedescription'] == NULL) { $bt = 'Unknown Booking Type'; } else { $bt = $performance['bookingtypedescription']; }
					if ($performance['ticketpricemin'] == NULL) { $tpmin = '?'; } else { $tpmin = "$".$performance['ticketpricemin']; }
					if ($performance['ticketpricemax'] == NULL) { $tpmax = '?'; } else { $tpmax = "$".$performance['ticketpricemax']; }
					if ($tpmin == $tpmax) {$ticketpricerange = $tpmin;} else {$ticketpricerange = $tpmin." - ".$tpmax;}
					//since the stored procedure has been updated, cancelled shows should never appear
					//but if in the future we want them to I am leaving this code here - 11/14/2019 ZF
					if ($performance['wascancelled'] == 1) { $can = 'CANCELLED'; } else { $can = ''; }
					if ($performance['middlename'] == NULL) { $mn = ''; } else { $mn = ' '.$performance['middlename']; }
					$d = date('M d, Y', strtotime($performance['performancedate']));
					if ($performance['performancedate'] == $past_date) {
					echo "<br/>".$performance['starttime']." - <a href='explorePerformers.php?Performer=".$performance['performerid']."'>".$performance['firstname'].$mn." ".$performance['lastname']."</a> (".$bt.") - Ticket Price: ".$ticketpricerange." ".$can;
					}
					elseif ($performance['performancedate'] != $past_date && $counter == 0) {
					echo "</div><div class=listing><u><b>".$d."</b></u><br/><br/>".$performance['starttime']." - <a href='explorePerformers.php?Performer=".$performance['performerid']."'>".$performance['firstname'].$mn." ".$performance['lastname']."</a> (".$bt.") - Ticket Price: ".$ticketpricerange." ".$can;
					}
					else {
					echo "<br/><br/><div class=listing><u><b>".$d."</b></u><br/><br/>".$performance['starttime']." - <a href='explorePerformers.php?Performer=".$performance['performerid']."'>".$performance['firstname'].$mn." ".$performance['lastname']."</a> (".$bt.") - Ticket Price: ".$ticketpricerange." ".$can;
					}
					$past_date = $performance['performancedate'];
					$counter = $counter + 1;
				}
				else {
					break;
				}	
			}	
			echo "</div>";

            mysqli_free_result($result);
            mysqli_close($dbcon); 

         ?>

	  	  <?php 
			//connect
			require_once './comedy.config';

			//connect to database
			$dbcon = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database'])
			or die('Could not connect: ' . mysqli_connect_error());

			//get input
			$VEN = $_REQUEST['Venue'];

			//find info about performer
			$query = "CALL GetVenueBookingInfo(".$VEN.")";
			$result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));

			//get past performance data
			echo "<br/><div>
				  <hr><h2>Past Shows</h2><hr>";
			$past_date = '';
			$counter = 0;
			while ($performance = mysqli_fetch_array($result)) {
				if ($performance['performancedate'] < date('Y-m-d') && $performance['performancedate'] != NULL) {		
					if ($performance['bookingtypedescription'] == NULL) { $bt = 'Unknown Booking Type'; } else { $bt = $performance['bookingtypedescription']; }
					if ($performance['ticketpricemin'] == NULL) { $tpmin = '?'; } else { $tpmin = "$".$performance['ticketpricemin']; }
					if ($performance['ticketpricemax'] == NULL) { $tpmax = '?'; } else { $tpmax = "$".$performance['ticketpricemax']; }
					if ($tpmin == $tpmax) {$ticketpricerange = $tpmin;} else {$ticketpricerange = $tpmin." - ".$tpmax;}
					//since the stored procedure has been updated, cancelled shows should never appear
					//but if in the future we want them to I am leaving this code here - 11/14/2019 ZF
					if ($performance['wascancelled'] == 1) { $can = 'CANCELLED'; } else { $can = ''; }
					if ($performance['middlename'] == NULL) { $mn = ''; } else { $mn = ' '.$performance['middlename']; }
					$d = date('M d, Y', strtotime($performance['performancedate']));
					if ($performance['performancedate'] == $past_date) {
					echo "<br/>".$performance['starttime']." - <a href='explorePerformers.php?Performer=".$performance['performerid']."'>".$performance['firstname'].$mn." ".$performance['lastname']."</a> (".$bt.") - Ticket Price: ".$ticketpricerange." ".$can;
					}
					elseif ($performance['performancedate'] != $past_date && $counter == 0) {
					echo "</div><div class=listing><u><b>".$d."</b></u><br/><br/>".$performance['starttime']." - <a href='explorePerformers.php?Performer=".$performance['performerid']."'>".$performance['firstname'].$mn." ".$performance['lastname']."</a> (".$bt.") - Ticket Price: ".$ticketpricerange." ".$can;
					}
					else {
					echo "<br/><br/><div class=listing><u><b>".$d."</b></u><br/><br/>".$performance['starttime']." - <a href='explorePerformers.php?Performer=".$performance['performerid']."'>".$performance['firstname'].$mn." ".$performance['lastname']."</a> (".$bt.") - Ticket Price: ".$ticketpricerange." ".$can;
					}
					$past_date = $performance['performancedate'];
					$counter = $counter + 1;
				}
			}

			echo "</div>";

			mysqli_free_result($result);
            mysqli_close($dbcon);
		   ?>

		</div>

	</body>
</html>