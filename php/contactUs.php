<?php
   $to_email = "ProjectCCDB@gmail.com";
   $subject = "User Message";
   $body = $_POST['Message'] . ' (' . $_POST['Name'] . ' - ' . $_POST['Email'] . ')';
   $header = "From: projectccdb_webapp@gmail.com\r\n";
   $header.= "MIME-Version: 1.0\r\n";
   $header.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
   $header.= "X-Priority: 1\r\n";

   if (mail($to_email, $subject, $body, $header)) {
      echo("Your message was successfully sent.");
   } else {
      echo("Email sending failed.");
   }
?>