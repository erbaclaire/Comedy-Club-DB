<?php
  session_start();
  require_once './comedy.config';
  include('faviconInfo.php');
?>

<!DOCTYPE html>
<html>

	<head>
	    
	    <title>Project CCDB</title>
	    <link rel="stylesheet" href="css/index_css.css">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet"> 
		<!--<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet"> -->
    </head>

    <body>

    	<!-- Add links to navigation menu -->
    	<!-- Some links dependant on whether logged in or not -->
	    <?php 
	    	if (!isset($_SESSION['username'])) {
		    	echo
			    '<div id="Nav" class="dropdown sticky">
			    	<button onclick="openNav()" class="dropbtn">&#9776;</button>
				    <div id="dropdownContent" class="dropdown-content">
					    <a href="index.php">Home</a><br/>					    
					    <a href="#About">About</a><br/>
						<a href="#Explore">Explore the Data</a><br/>
					    <a href="#Contact">Contact Us</a><br/>
				    </div>
			    </div>
				<div class=login>
				    <form id="Login" name="Login" action="Login.php" method="POST">
				        <input type="text" name="username" placeholder="username" required />
				        <input type="password" name="password" placeholder="password" required />
				        <button class="button button1" type="submit">login</button>
					</form>
				</div>';
			}
        	else {
		    	echo
			    '<div id="Nav" class="dropdown sticky">
			    	<button onclick="openNav()" class="dropbtn">&#9776;</button>
				    <div id="dropdownContent" class="dropdown-content">
					    <a href="index.php">Home</a><br/>
						<a href="#About">About</a><br/>
						<a href="#Explore">Explore the Data</a><br/>
					    <a href="Performer.php">Create a Comedian Profile</a><br/>
					    <a href="Booking.php">Add a Booking</a><br/>
					    <a href="#Contact">Contact Us</a><br/>
				    </div>
			    </div>
				<div class=login>
				    <form id="Logout" name="Logout" action="Logout.php" method="POST">
				        <button class="button button1" type="submit">Logout</button>
					</form>
				</div>';
			}
        ?>

        <!-- Logo -->
        <br/><br/><br/><br/>
       	<div><center><img class=img1 src="images/Logo.jpg"></center></div>

	    <!-- About -->
	    <div id="About" class=about>
	    	<h1 align="center">ABOUT</h1>
	    	<p style="text-align: left;">
				Project CCDB came to fruition when a few comedians in a text feed were complaining about the lack of women/POC diversity in nationwide comedy club line-ups, even in large markets like Los Angeles, where the population contains more than enough qualified (audience-drawing) comics for booking. 
			</p>
			<button type="button" class="collapsible" id="LessMoreButton"> More ... </button>
			<p class="content">
				After months of exchanging photos of predominantly white male lineups, these comics got sick of complaining about it and connected with an interested computer scientist to gather actual data from clubs over a three month period and see if the hearsay was true or just rumors of a resentful messaging group. So, here are the facts as they stand of what genders and ethnicitites are most represented. Though it may not change the booking practices of every club owner, maybe a few will be inspired to include and add to their profits by hiring all comedians and not just predominantly one majority. We are doing this also because we love comedy and comedy clubs. And we wonder if clubs are leaving money on the table. Maybe a booker can replace a dark night or non-drawing-though-regularly-booked male act with a sold-out crowd of underserved audiences (LGBTQIA+, minorities, women, differently-abled) ordering curly fries and a pitcher of Jagermeister.  Lots of human beings love comedy (as the growing comedy festival circuit demonstrates)! And if all of this effort and data entry  goes unused, ignored and therefore, useless, then the joke’s on us! And that’s actually pretty hilarious when you think about it.
			</p>
		</div>

		<!-- Explore the data -->
		<div id="Explore" class=explore>
			<h1 align="center">EXPLORE THE DATA</h1>

			<!-- Search Comedians and Comedy Venues --> 
			<div id="Explore" align="center">
				<p style="text-align: center;">The reports below are based on booking data gathered from 55 comedy clubs across the country over a three month period (September-November 2019).</p> 
				<p style="text-align: center;">Each report allows you to filter based on gender identity, ethnicity, type of booking (opener, middle, headliner) and date of booking.</p>

				<center><button class ="button-3 button3" type="submit" onclick="window.location.href='./Explore.php'"><strong>VIEW MORE REPORTS</strong></button></center>

				<div class='tableauPlaceholder' id='viz1573791192049' style='position: relative'><noscript><a href='#'><img alt=' ' src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;To&#47;TotalBookingswNumbers&#47;TotalBookingswNumbers&#47;1_rss.png' style='border: none' /></a></noscript><object class='tableauViz'  style='display:none;'><param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='' /><param name='name' value='TotalBookingswNumbers&#47;TotalBookingswNumbers' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='static_image' value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;To&#47;TotalBookingswNumbers&#47;TotalBookingswNumbers&#47;1.png' /> <param name='animate_transition' value='yes' /><param name='display_static_image' value='yes' /><param name='display_spinner' value='yes' /><param name='display_overlay' value='yes' /><param name='display_count' value='yes' /></object></div>                <script type='text/javascript'>                    var divElement = document.getElementById('viz1573791192049');                    var vizElement = divElement.getElementsByTagName('object')[0];                    if ( divElement.offsetWidth > 800 ) { vizElement.style.minWidth='420px';vizElement.style.maxWidth='650px';vizElement.style.width='100%';vizElement.style.minHeight='587px';vizElement.style.maxHeight='887px';vizElement.style.height=(divElement.offsetWidth*0.75)+'px';} else if ( divElement.offsetWidth > 500 ) { vizElement.style.minWidth='420px';vizElement.style.maxWidth='650px';vizElement.style.width='100%';vizElement.style.minHeight='587px';vizElement.style.maxHeight='887px';vizElement.style.height=(divElement.offsetWidth*0.75)+'px';} else { vizElement.style.width='100%';vizElement.style.height='1127px';}                     var scriptElement = document.createElement('script');                    scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';                    vizElement.parentNode.insertBefore(scriptElement, vizElement);                </script></div>

				<center><button class ="button-3 button3" type="submit" onclick="window.location.href='./Explore.php'"><strong>VIEW MORE REPORTS</strong></button>
			
				<h3><em>View bookings for your favorite comedians and venues.</em></h3>

				<form id="explorePerformers" name="explorePerformers" action="explorePerformers.php" onsubmit="return validatePerformer()" method="GET">
					<select  name='Performer' id='Performer' style="display: inline-block;">
						<option  value='0'>Select a Comedian</option>
						<?php
						$myConnection = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database']);

						$query = 'CALL GetPerformers;';
						$result = mysqli_query($myConnection, $query) or die ("Failed to fetch performer data.");
	                    
						while ($tuple = mysqli_fetch_array($result)) {       
							echo "<option value='" . $tuple['performerid'] ."'>" . $tuple['firstname'] . " " . $tuple['lastname'] . "</option>";      
						}
						echo "</select>";

						mysqli_free_result($result);
						mysqli_close($myConnection);  
						?>
					<button class="button-3 button3" style="display: inline-block;" type="submit">&#10149;</button>
				</form>

				<form id="exploreVenues" name="exploreVenues" action="exploreVenues.php" onsubmit="return validateVenue()" method="GET">
					<select name='Venue' id='Venue' style="display: inline-block;">
						<option  value='0'>Select a Venue</option>
						<?php
						$myConnection = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database']);

						$query = 'CALL GetVenues;';
						$result = mysqli_query($myConnection, $query) or die ("Failed to fetch venue data.");
	                    
						while ($tuple = mysqli_fetch_array($result)) {       
							echo "<option value='" . $tuple['venueid'] ."'>" . $tuple['venuename'] . "</option>";              
						}
						echo "</select>";

						mysqli_free_result($result);
						mysqli_close($myConnection);  
						?>
					<button class="button-3 button3" style="display: inline-block;" type="submit">&#10149;</button>
				</form>
				</center>
			</div>
		</div>


	    <div><br/>
		</div>	

	    

		<!-- Contact Us -->
		<center>
		<div id="Contact" class="contact">
			<div align="center" style="padding-top: 2%; padding-bottom: 2%;"><h2>Please reach out if you have any questions, comments or suggestions.</h2></div>
        	<form id="contactUs" name="contactUs" action="contactUs.php" method="POST">
        		<div class=row>
	        		<div class="contact-column left">
		        		<div class=name-email>
							<input style="border-radius: 25px; width: 350px;" type="text" id="Name" name="Name" required/><br/>
							<label for="FName">NAME</label><br/>
						</div>
						<br/>
						<div class=name-email>
						    <input style="border-radius: 25px; width: 350px;" type="text" id="Email" name="Email" required/><br/>
						    <label for="Email">EMAIL</label><br/>
						</div>
					</div>
				    <div class="contact-column right">
			        	<textarea id="Message" name="Message" required></textarea><br/>
		        		<label for="Message">MESSAGE</label><br/>
			        	<br/>
			       	</div>
		      	</div>
		      	<button class="button-2 button2" type="submit">Send Message</button><br/><br/>
        	</form>
        </div>
        </center>

		<!-- Go Fund Me & Misc. -->
		<div id="Clarify">
			<p style="padding-left: 3%; padding-right: 3%;">
			<img class=img2 align="bottom" src="images/yellow favicon.jpg">
			Because the scope of this information was so great and the budget so small, we didn’t include the equally important representations of sexual orientation, the differently-abled and other marginalized persons. We apologize in advance. At this point, this is an overly-simplified study that doesn’t recognize all comedians’ experiences.
			</p>
		</div>
		<!--<div id="Misc" align="center" style="float: left; padding: 3%; color: grey;">
		Please consider donating to our <a href="[ADD GOFUNDME LINK]">GoFundMe</a> to help ensure we can continue collecting data and offering this information for free to the general public.Special thanks to Maria Bamford for taking the initiative and sponsoring this project and to Claire Erba and Zach Freeman, the programmers who donated their time to this project.
		</div>-->

		<!-- SCRIPTS -->
	    <!-- Scripts for validating explore performer and venue queries -->
	    <script>
	        function validatePerformer() {
	          var per = document.forms["explorePerformers"]["Performer"].value;
	          if (per == "0") {
	            alert("A performer must be selected.");
	            return false;
	          }
	        } 
	     </script>
	     <script>
	        function validateVenue() {
	          var ven = document.forms["exploreVenues"]["Venue"].value;
	          if (ven == "0") {
	            alert("A venue must be selected.");
	            return false;
	          }
	        }
	      </script>

		<!-- Script for running contactUs.php code on submit and not redirecting page --> 
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script>
          $(document).ready(function() {
	          $('#contactUs').on('submit', function(e){
	              //Stop the form from submitting itself to the server.
	              e.preventDefault();
	              var Name = $('#Name').val(); var Email = $('#Email').val(); var Message = $('#Message').val();
	              $.ajax({
	                type: "POST",
	                url: 'contactUs.php',
	                data: {Name: Name, Email: Email, Message: Message},
	                success: function(data){
	                  alert(data);
	                  document.getElementById('contactUs').reset();
	                }
	             });
	          });
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

 		<!-- Script to open Our Info section -->
 		<script>
		var coll = document.getElementsByClassName("collapsible");
		var i;

		for (i = 0; i < coll.length; i++) {
		  coll[i].addEventListener("click", function() {
		    this.classList.toggle("active");
		    var content = this.nextElementSibling;
		    if (content.style.display === "block") {
		      content.style.display = "none";
			  LessMoreButton.innerText = "More...";
		    } else {
		      content.style.display = "block";
			  LessMoreButton.innerText = "Less...";
		    }
		  });
		}
		</script>

	</body>

</html>
