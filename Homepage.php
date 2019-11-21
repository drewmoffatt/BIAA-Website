<!DOCTYPE html>
<html>
<head>
  <link href="calendar.css" rel="stylesheet"></link>
<style>

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    border: 1px solid #e7e7e7;
    background-color: #f3f3f3;
}

li {
    float:left;
}

li a {
    display: block;
    color: #003366;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #FFFFFF;
}

li a.active {
    color: #003366;
    background-color: #ddd;
}
  #Bluejay {
	text-align: center;
  }
  #Title {
	font-weight: Bold;
	font-size: 2em;
	text-align: center;
	
	@media screen and (max-width: 980px/whatever number you choose) {
  #Bluejay {
	text-align: center;
}
</style>
</head>
<body>
  
<ul>
  <li><a class="active" href="">Home</a></li>
  <li><a href="schedule.php">Calendar</a></li>
  <li><a href="">Projects</a></li>
  <li><a href="">Discussion Board</a></li>
  <li><a href="login.php">Profile</a></li>
</ul>
  <br>
    <section id="Title">Business Intelligence & Analytics Association</section>
  <br>
</body>
</html>