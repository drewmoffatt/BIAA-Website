<?php
// sets a PHP content variable in case the form isn't submitted
$content = "The form has not been submitted.";

// checks if the form has been submitted
if (isset($_POST["submit"])) 
{
  // imports the PHP connection file
  require_once("db.php");

  // stores into a PHP variable the submitted member from the login page
  $username = mysqli_real_escape_string($con, stripslashes($_POST["username"]));
  $password = mysqli_real_escape_string($con, stripslashes($_POST["password"]));

  // queries the user table in the database for the entered username and password
  $query = 
	"SELECT *
    FROM `999group1c`.`member`
    WHERE NETID IN (UPPER('{$username}'),LOWER('{$username}'))
    AND NETID IN (UPPER('{$username}'),LOWER('{$username}'));";
  $results = mysqli_query($con, $query) or die("Query failed: " . mysqli_error($con));
  $row = mysqli_fetch_array($results);

  // checks to see if a match is found for a specific username/password combination
  if(mysqli_num_rows($results) > 0){

	// destroys any existing sessions and starts a new session
	session_start();

	// sets the username session variable
	$_SESSION["user"] = $username;


	// sets the error message if there is no matching username/password combination
  } else {
	echo "Your login credentials are incorrect!";
	exit;
  }

  // free query results
  mysqli_free_result($results);
}
if (isset($_SESSION["user"])) 
{	
  // adds a header that will be displayed to the browser
  $content = "<h3>Member Profile:</h3>";

  // queries member information for the entered member and stores the results
  $query = 
	"SELECT netid, first_name, last_name, phone, major
	FROM memberInfo 
	WHERE netid IN (UPPER('{$username}'),LOWER('{$username}'))
	AND netid = '$password'";
  $results = mysqli_query($con, $query) or die("<br><b>Query failed</b>: " . mysqli_error($con) . "<pre>{$query}</pre><br>");


  // starts the results table with headers
  $content .= 
	"<table>
		<tr>
			<th>NetID</th>
	 		<th>First Name</th>
			<th>Last Name</th>
	 		<th>Phone Number</th>
			<th>Major</th>
		</tr>";

  // loops through the results of the query
  while ($row = mysqli_fetch_array($results)) 
  {

	// stores each row in the content variable 
	$content .= 
	  "<tr>
	  	<td>{$row["netid"]}</td>
	 	<td>{$row["first_name"]}</td>
	 	<td>{$row["last_name"]}</td>
		<td>{$row["phone"]}</td>
	 	<td>{$row["major"]}</td>
	</tr>";
  }
  "</table>"; 

  // frees the results and closes the connection
  mysqli_free_result($results);
  mysqli_close($con);
}
?>

<!-- begins the HTML code -->
<!doctype html>
<html>
  <head>
	<title>Member Profile</title>
	<link href="main.css" rel="stylesheet">
  </head>
  <body>
	<div class="container">
	  <div>
		<?php echo $content; ?>
	  </div>
	</div>
  </body>
</html>