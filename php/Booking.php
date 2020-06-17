<?php
	require_once './comedy.config';
	session_start();
  include('faviconInfo.php'); 

	if (!isset($_SESSION['username'])) {
	header("Location: Login.php"); 
	exit;
	}
?>
<!DOCTYPE html>
<html>

  <head>

  	<title>Project CCDB</title>
    <link rel="stylesheet" href="css/booking_performer_css.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet"> 
	<!--<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet"> -->
  </head>

  <body>

    <!-- Links -->
    <div id="Nav" class="dropdown">
    	<button onclick="openNav()" class="dropbtn">&#9776;</button>
	    <div id="dropdownContent" class="dropdown-content">
		    <a href="index.php">Home</a><br/>
		    <a href="Explore.php">Explore the Data</a><br/>
			<a href="Performer.php">Create a Comedian Profile</a><br/>
			<a href="Logout.php">Logout</a>
	    </div>
    </div>

    <!-- Header -->
    <br/><br/>
    <div class="form_fields" style="font-size:40px;">
      Add a Performance
    </div>

    <!-- Form for adding a performance -->
    <br/><br/>
    <form id="addBooking" name="addBooking" action="addBooking.php" method="POST">
      <div class="form_fields">
        Select a Performer*<br/>
          <?php
            $myConnection = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database']);

            $query = 'CALL GetPerformers;';
            $result = mysqli_query($myConnection, $query) or die ("Failed to fetch performer data.");
              
            echo "<select id='Performer' name='Performer'>";
            echo "<option value='select'>Select</option>";
            while ($tuple = mysqli_fetch_array($result))
            {       
                echo "<option value='" . $tuple['performerid'] ."'>" . $tuple['firstname'] . " " . $tuple['lastname'] . "</option>";             
            }
            echo "</select>";

            mysqli_free_result($result);
            mysqli_close($myConnection);  
          ?>
      </div>
      <br/><br/><br/>
      <div class="form_fields">
        Select a Venue*<br/>
          <?php
            $myConnection = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database']);

            $query = 'CALL GetVenues;';
            $result = mysqli_query($myConnection, $query) or die ("Failed to fetch venue data.");
              
            echo "<select id='Venue' name='Venue'>";
  			echo "<option value='select'>Select</option>";
            while ($tuple = mysqli_fetch_array($result))
            {       
                echo "<option value='" . $tuple['venueid'] ."'>" . $tuple['venuename'] . "</option>";               
            }
            echo "</select>";

            mysqli_free_result($result);
            mysqli_close($myConnection);  
          ?>
      </div>
      <br/><br/><br/>
      <div class="form_fields">Performance Date*</div>
      <br/>
      <div class="form_fields">
        Month<br/>
        <select id="Month" name="Month" style="width: 300px;">
          <option value='select'>Select</option>
          <option value="01">January</option>
          <option value="02">February</option>
          <option value="03">March</option>
          <option value="04">April</option>
          <option value="05">May</option>
          <option value="06">June</option>
          <option value="07">July</option>
          <option value="08">August</option>
          <option value="09">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>     
        </select>  
      </div> 
      <div class="form_fields">
        Day<br/>
        <select id="Day" name="Day">
          <option value='select'>Select</option>
          <option value="01">1</option> 
          <option value="02">2</option> 
          <option value="03">3</option> 
          <option value="04">4</option> 
          <option value="05">5</option> 
          <option value="06">6</option> 
          <option value="07">7</option> 
          <option value="08">8</option> 
          <option value="09">9</option> 
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
      </div> 
      <div class="form_fields">
        Year<br/>
        <select id="Year" name="Year">
          <option value='select'>Select</option>
          <option value="2022">2022</option>
          <option value="2021">2021</option>
          <option value="2020">2020</option>
		  <option value="2019">2019</option>
          <option value="2018">2018</option>
          <option value="2017">2017</option>
          <option value="2016">2016</option>
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
        </select>  
      </div> 
      <br/><br/><br/>
      <div class="form_fields">Performance Time*</div>
      <br/>
      <div class="form_fields">
        Hour<br/>
        <select id="Hour" name="Hour">
          <option value='select'>Select</option>
          <option value="01">1</option>
          <option value="02">2</option>
          <option value="03">3</option>
          <option value="04">4</option>
          <option value="05">5</option>
          <option value="06">6</option>
          <option value="07">7</option>
          <option value="08">8</option>
          <option value="09">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>     
        </select>  
      </div> 
      <div class="form_fields">
        Minutes<br/>
        <select id="Minutes" name="Minutes">
          <option value='select'>Select</option>
          <option value="00">00</option>
          <option value="15">15</option>
          <option value="30">30</option>
          <option value="45">45</option>    
        </select>  
      </div> 
      <div class="form_fields">
        AM/PM<br/>
        <select id="AMPM" name="AMPM">
          <option value='select'>Select</option>
          <option value="AM">AM</option>
          <option value="PM">PM</option>   
        </select>  
      </div>   
      <br/><br/> <br/>
      <div class="form_fields"> 
  		Booking Type*<br/>
  	  <?php
  			$myConnection = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database']);

  			$query = 'CALL GetBookingTypes;';
  			$result = mysqli_query($myConnection, $query) or die ("Failed to fetch booking type data.");
  				
  			echo "<select id='BookingType' name='BookingType'>";
  			echo "<option value='select'>Select</option>";
  			while ($tuple = mysqli_fetch_array($result))
  			{				
  					echo "<option value='" . $tuple['bookingtypecode'] ."'>" . $tuple['bookingtypedescription'] . "</option>";									
  			}
  			echo "</select>";

  			mysqli_free_result($result);
  			mysqli_close($myConnection);	
  	  ?>
      </div> 
      <br/><br/><br/>
      <div class="form_fields">
      	<label style="float: left;" for="TPR1">Ticket Price Range</label><br/>
        <input type="text" placeholder="e.g., 10.00" id='TPR1' name="TPR1" style="width: 150px; height: 32px;"/> 
        -
        <input type="text" placeholder="e.g., 100.00" id='TPR2' name="TPR2" style="width: 150px; height: 32px;"/> 
      </div>  
      <br/><br/><br/>
      <div class="form_fields">
        <button class="button button1" type="submit">Add Performance</button>
      </div> 
    </form>

    <!-- SCRIPTS -->
    <!-- Script for validating form input and running php code on submit and not redirecting page -->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script>
      $(document).ready(function() {
      $('#addBooking').on('submit', function(e){
        //Stop the form from submitting itself to the server.
          e.preventDefault();
          var Performer = $('#Performer').val(); var Venue = $('#Venue').val(); 
          var Month = $('#Month').val(); var Day = $('#Day').val(); var Year = $('#Year').val();
          var Hour = $('#Hour').val(); var Minutes = $('#Minutes').val(); var AMPM = $('#AMPM').val();
          var BookingType = $('#BookingType').val(); 
          var TPR1 = $('#TPR1').val(); var TPR2 = $('#TPR2').val();
              function isNumeric(n) { 
            return !isNaN(parseFloat(n)) && isFinite(n); 
          }
          function validateDate(m, d, y) {
            if ((m == "04" || m == "06" || m == "09" || m == "11") && parseInt(d) > 30)  {
              alert("Invalid date.");
            return false;
          }
          else if (m == "02" && y%4 != 0 && parseInt(d) > 28 ) {
            alert("Invalid date.");
            return false;
          }
          else if (m == "02" && y%4 == 0 && parseInt(d) > 29 ) {
            alert("Invalid date.");
            return false;
          }
          }
          if (Performer == "select") {
            alert("A performer must be selected.");
            return false;
          }
          if (Venue == "select") {
            alert("A venue must be selected.");
            return false;
          }
          if (Month == "select") {
            alert("The month of the performance must be selected.");
            return false;
          }
          if (Day == "select") {
            alert("The day of the performance must be selected.");
            return false;
          }
          if (Year == "select") {
            alert("The year of the performance must be selected.");
            return false;
          }  
          validateDate(Month, Day, Year);
          if (Hour == "select") {
            alert("The hour of the performance performance start time must be selected.");
            return false;
          } 
          if (Minutes == "select") {
            alert("The minutes of the performance start time must be selected.");
            return false;
          } 
          if (AMPM == "select") {
            alert("Whether the performance occured in the AM or PM must be selected.");
            return false;
          } 
          if (BookingType == "select") {
            alert("The booking type must be selected.");
            return false;
          } 
          if ((TPR1 != "" && !isNumeric(TPR1)) || (TPR2 != "" && !isNumeric(TPR2))) {
            alert("If a ticket price is entered it must be numeric.");
            return false;
          }
          if ((TPR1 != "" && Number(TPR1) < 0) || (TPR2 != "" && Number(TPR2) < 0)) {
            alert("Ticket price cannot be less than $0.");
            return false;
          }
          if (TPR1 != "" && TPR2 != "" && TPR2 < Number(TPR1)) {
            alert("The maximum ticket price must be greater than or equal to the minimum ticket price.");
            return false;
          }
          $.ajax({
            type: "POST",
            url: 'addBooking.php',
            data: {Performer: Performer, Venue: Venue, Month: Month, Day: Day, Year: Year, Hour: Hour, Minutes: Minutes, AMPM: AMPM, BookingType: BookingType, TPR1: TPR1, TPR2: TPR2},
            success: function(data){
              alert(data);
            }
          });
      } );
      });
    </script>

    <!-- Script to open and close nav bar -->
    <script>
	function openNav() {
	  document.getElementById("dropdownContent").classList.toggle("show");
	}
	window.onclick = function(event) {
	  if (!event.target.matches('.dropbtn')) {
	    var dropdowns = document.getElementsByClassName("dropdown-content");
	    var i;
	    for (i = 0; i < dropdowns.length; i++) {
	      var openDropdown = dropdowns[i];
	      if (openDropdown.classList.contains('show')) {
	        openDropdown.classList.remove('show');
	      }
	    }
	  }
	}
	</script>
    
  </body>

</html>