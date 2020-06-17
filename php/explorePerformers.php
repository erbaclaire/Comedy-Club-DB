<!DOCTYPE html>
<html>
	<head>		
		<title>Project CCDB</title>
		<?php include('faviconInfo.php'); ?>
		<link rel="stylesheet" href="css/explore_venues_performers_css.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>

	<div class="split left">
	    <?php 
			//connect
			require_once './comedy.config';

			//connect to database
			$dbcon = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database'])
			or die('Could not connect: ' . mysqli_connect_error());

			//get input
			$PER = $_REQUEST['Performer'];

			//set default timezone
			date_default_timezone_set('US/Eastern');

			//find info about performer
			$query = "CALL GetPerformerInfoBasic(".$PER.")";
			$result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
			$performer = mysqli_fetch_row($result);

			if ($performer[8] == NULL || $performer[8] == '') { $photo = 'https://iupac.org/wp-content/uploads/2018/05/default-avatar.png'; } else { $photo = $performer[8]; }
			if ($performer[2] == NULL) { $mn = ''; } else { $mn = " ".$performer[2]; }
			if ($performer[9] == 1) { $dis = 'Yes'; } else { $dis = 'No'; }
			if ($performer[7] == NULL) {$web = '';} else { $web = "<p><b>Website: </b><a href='".$performer[7]."' target='_blank'><font color='blue'>".$performer[7]."</font></a></p>"; }
			if ($performer[6] == NULL) {$b = '';} else { $b = "<p><b>Bio: </b><br/>".$performer[6]."</p>"; }
			$bd = date('M d, Y', strtotime($performer[4]));
			if ($bd == 'Jan 01, 1970') {$dateofbirth = '';} else { $dateofbirth = "<p><b>Date of Birth: </b>".$bd."</p>"; }
			//print info about performer - not displaying disability for now - til we determine what to do with this data
	    	echo '<img src="'.$photo.'" height="200" width="250" alt="Profile Pic">
				  <h2>'.$performer[1].' '.$mn.' '.$performer[3].'</h2>'.
	    		  
	    		  //<p><b>Ethnicity: </b>'.$performer[10].'</p>'.
	    		  //<p><b>Gender: </b>'.$performer[5].'</p>

				  //<p><b>Disability: </b>'.$dis.'</p>'.
	    		  $dateofbirth.
				  $web.
	    		  $b;

            mysqli_free_result($result);
            mysqli_close($dbcon); 
	    ?>
	    <br>
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
			$PER = $_REQUEST['Performer'];

			//find info about performer
			$query = "CALL GetPerformerBookingInfo(".$PER.")";
			$result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));

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
					if ($performance['wascancelled'] == 1) { $can = '<br/>CANCELLED'; } else { $can = '<br/>'; }
					$d = date('M d, Y', strtotime($performance['performancedate']));
					if ($performance['performancedate'] == $past_date) {
					echo "<br/>".$performance['starttime']." (".$bt.") - <a href='exploreVenues.php?Venue=".$performance['venueid']."'>".$performance['venuename']."</a> (Ticket Price: ".$ticketpricerange.") ".$can;
					}
					elseif ($performance['performancedate'] != $past_date && $counter == 0) {
					echo "</div><div class=listing><u><b>".$d."</b></u><br/><br/>".$performance['starttime']." (".$bt.") - <a href='exploreVenues.php?Venue=".$performance['venueid']."'>".$performance['venuename']."</a> (Ticket Price: ".$ticketpricerange.") ".$can;
					}
					else {
					echo "<br/><br/><div class=listing><u><b>".$d."</b></u><br/><br/>".$performance['starttime']." (".$bt.") - <a href='exploreVenues.php?Venue=".$performance['venueid']."'>".$performance['venuename']."</a> (Ticket Price: ".$ticketpricerange.") ".$can;
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
			$PER = $_REQUEST['Performer'];

			//find info about performer
			$query = "CALL GetPerformerBookingInfo(".$PER.")";
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
					if ($performance['wascancelled'] == 1) { $can = '<br/>CANCELLED'; } else { $can = ''; }
					$d = date('M d, Y', strtotime($performance['performancedate']));
					if ($performance['performancedate'] == $past_date) {
					echo "<br/>".$performance['starttime']." (".$bt.") - <a href='exploreVenues.php?Venue=".$performance['venueid']."'>".$performance['venuename']."</a> (Ticket Price: ".$ticketpricerange.") ".$can;
					}
					elseif ($performance['performancedate'] != $past_date && $counter == 0) {
					echo "</div><div class=listing><u><b>".$d."</b></u><br/><br/>".$performance['starttime']." (".$bt.") - <a href='exploreVenues.php?Venue=".$performance['venueid']."'>".$performance['venuename']."</a> (Ticket Price: ".$ticketpricerange.") ".$can;
					}
					else {
					echo "<br/><br/><div class=listing><u><b>".$d."</b></u><br/><br/>".$performance['starttime']." (".$bt.") - <a href='exploreVenues.php?Venue=".$performance['venueid']."'>".$performance['venuename']."</a> (Ticket Price: ".$ticketpricerange.") ".$can;
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