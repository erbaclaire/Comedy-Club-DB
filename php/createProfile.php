<?php
   //connect
   require_once './comedy.config';
   session_start();

   //connect to database
   $dbcon = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database'])
            or die('Could not connect: ' . mysqli_connect_error());

   //get input
   //$UN = str_replace("'", "''", $_REQUEST['UName']);
   $FN = str_replace("'", "''", $_REQUEST['FName']);
   $MN = str_replace("'", "''", $_REQUEST['MName']);
   $LN =  str_replace("'", "''", $_REQUEST['LName']);
   $DOBM = $_REQUEST['Month'];
   $DOBD = $_REQUEST['Day'];
   $DOBY = $_REQUEST['Year'];
   $GEN =  $_REQUEST['Gender'];
   $ETH =  $_REQUEST['Ethnicity'];
   $DIS =  $_REQUEST['Disability'];
   $BIO =  str_replace("'", "''", $_REQUEST['Bio']);
   $WLINK =  str_replace("'", "''", $_REQUEST['WebLink']);
   $PLINK =  str_replace("'", "''", $_REQUEST['PhotoLink']);
   $CB = $_SESSION['username'];

   //edit data for DB entry

      //dob
      $DOB = $DOBY . "-" . $DOBM . "-" . $DOBD;

      //disability boolean
      if ($DIS == "Y") { $DIS_BOOL = 1; } else { $DIS_BOOL = 0;}

   //add new performer to the database
   $date = gmdate('Y-m-d h:i:s \G\M\T');
   $performer_insert = "CALL CreatePerformer('$FN', NULLIF('$MN',''), '$LN', '$DOB', '$GEN', '$ETH', NULLIF('$BIO',''), NULLIF('$WLINK',''), NULLIF('$PLINK', ''), $DIS_BOOL, '$date', '$CB', NULL, NULL)";
   $performer_insert_result = mysqli_query($dbcon, $performer_insert) or die("FAILED! ".mysqli_error($dbcon));

   echo 'A performer profile for '.$FN.' '.$LN.' was successfully created!';

   mysqli_close($dbcon);
?>