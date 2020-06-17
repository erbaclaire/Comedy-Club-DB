<?php
   //connect
   require_once './comedy.config';
   session_start();

   //connect to database
   $dbcon = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database'])
	    or die('Could not connect: ' . mysqli_connect_error());

   //get input
   $PER = $_REQUEST['Performer'];
   $VEN = $_REQUEST['Venue'];
   $PMON = $_REQUEST['Month'];
   $PDAY = $_REQUEST['Day'];
   $PYR = $_REQUEST['Year'];
   $PHR =  $_REQUEST['Hour'];
   $PMIN =  $_REQUEST['Minutes'];
   $PAMPM =  $_REQUEST['AMPM'];
//   $CAN =  $_REQUEST['Cancelled'];
   $BOOK =  $_REQUEST['BookingType'];
   $TPR1 =  $_REQUEST['TPR1'];
   $TPR2 =  $_REQUEST['TPR2'];
   $CB = $_SESSION['username'];

   //edit data for DB entry

      //performance month
      $PDATE = $PYR . "-" . $PMON . "-" . $PDAY;
    
      //cancelled boolean
//      if ($CAN == "Y") { $CAN_BOOL = 1; } else { $CAN_BOOL = 0;}
    
      //time
      if ($PAMPM == 'PM' && $PHR != '12') { $PTIME = ($PHR+12).":".$PMIN; } else { $PTIME = $PHR.":".$PMIN; }
      //make price null if not filled in
      if (trim($TPR1)=='') { $TPR1_round = "NULL"; } else { $TPR1_round = round($TPR1, 2); }
      if (trim($TPR2)=='') { $TPR2_round = "NULL"; } else { $TPR2_round = round($TPR2, 2); }

   //add new performance to the database
   $date = gmdate('Y-m-d h:i:s \G\M\T');
   $performance_insert = "CALL CreatePerformance($VEN, $PER, '$PDATE', '$PTIME', '$BOOK', $TPR1_round, $TPR2_round, 0, '$date', '$CB', NULL, NULL)";
   $performance_insert_result = mysqli_query($dbcon, $performance_insert) or die("FAILED! ".mysqli_error($dbcon));
   
   $p = "CALL GetPerformerInfo($PER)";
   $performer_result = mysqli_query($dbcon, $p) or die("FAILED! ".mysqli_error($dbcon));
   while ($performer = mysqli_fetch_array($performer_result)) {
      $performer_name = $performer['firstname'].' '.$performer['lastname'];
   }   
   mysqli_free_result($performer_result);
   mysqli_close($dbcon);
?>

<?php
   require_once './comedy.config';

   //connect to database
   $dbcon = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database'])
       or die('Could not connect: ' . mysqli_connect_error());

   $v = "CALL GetVenueInfo($VEN)";
   $venue_result = mysqli_query($dbcon, $v) or die("FAILED! ".mysqli_error($dbcon));
   while ($venue = mysqli_fetch_array($venue_result)) {
      $venue_name = $venue['venuename'];
   }
    
   echo 'A booking for '.$performer_name.' at '.$venue_name.' on '.$PDATE.' at '.$PHR.':'.$PMIN.' '.$PAMPM.' was successfully created!';
   
   mysqli_free_result($venue_result);
   mysqli_close($dbcon);
?>