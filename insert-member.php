<?php
// sets a PHP message variable in case the form isn't submitted
$message = "The form has not been submitted.";

// checks if the form has been submitted
if (isset($_POST["submit"])) 
{

  // imports the PHP connection file
  require_once("db.php");

  // stores the submitted values from the form into PHP variables
  $netid = $_POST["NETID"];
  $firstName = $_POST["FirstName"];
  $lastName = $_POST["LastName"];
  $gradYear = $_POST["GradYear"];
	
  // queries whether the invoice item already exists
  $query = 
    "SELECT *
     FROM `999group1c`.`member` 
     WHERE NETID = '$netid'";
  $results = mysqli_query($con, $query) or die("<br><b>Query failed</b>: " . mysqli_error($con) . "<pre>{$query}</pre><br>");

  // checks if the invoice item already exists (zero rows means the invoice item is not on the invoice)
  if (mysqli_num_rows($results)==0) 
  {

    // inserts the new invoice item
    $query = "INSERT INTO `999group1c`.`member` (NETID, firstName, lastName, gradYear, Email)
              VALUES ('$netid','$firstName', '$lastName',$gradYear,'$netid@creighton.edu')";

    // executes the query, notice that we don't store the results
    mysqli_query($con, $query) or die("<br><b>Query failed</b>: " . mysqli_error($con) . "<pre>{$query}</pre><br>");

    // adds the header and success message
    $message = "<h5>Inserted New Member</h5>Successfully added Member <b>$netid</b>.
				<br>
				<br>
	  			<a href='insert-member.html'>Add Another Member</a>";

  // runs if the invoice item already exists
  } else 
  {
	
	// updates the invoice
    $query = "UPDATE `999group1c`.`member` 
              SET firstName = '$firstName'
			  WHERE NETID = '$netid'";

    // executes the query, notice that we don't store the results
    mysqli_query($con, $query) or die("<br><b>Query failed</b>: " . mysqli_error($con) . "<pre>{$query}</pre><br>");
    // adds the header and message indicating the employee exists
    $message = "<h5>Member Exists</h5>Member information has been updated. 
				<br>
				<br>
	  			<a href='insert-member.html'>Add Another Member</a>";
  }
  
  // frees the results and closes the connection
  mysqli_free_result($results);
  mysqli_close($con);
}
?>

<!-- begins the HTML code and displays the message -->
<!doctype html>
<html>
  <head>
    <title>Insert/Update Member Information</title>
    <link href="main.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <?php echo $message; ?>
	  
    </div>
  </body>
</html>