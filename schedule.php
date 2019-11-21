<?php
// sets a blank PHP content variable
$content = "";

// imports the PHP connection file
require_once("db.php");
require_once("functions.php");

?>

<!-- HTML for Calendar -->
<html>
  <head>
	<link href="calendar.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="calendar.js"></script>
  </head>
  <body>
	<div id='calendar'><?php echo getCalendar($con); ?></div>
  	<div id='event-list'></div>
  </body>
</html>