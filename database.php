<?php
$servername = "localhost";
$username = "rachel_e";
$password = "password";
$dbname = "motreminder_re";


$mycontacts = "";
$xmycontacts = "";


/*######################################## OLD WAY #############################*/

$sql = "SELECT first_name,last_name,people_no FROM people where password = '".$_REQUEST['pw']."'";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if ( $row["first_name"] == "rachel" ) {
			$mycontacts .= "<tr><th style=\"border:1px solid #ccc; background-color: black; color: white;\">First name</th><td style=\"border:1px solid #ccc; background-color: black; color: white;\">" . $row["first_name"]. " Boo!</td></tr>";
		} else {
			$mycontacts .= "<tr><th style=\"border:1px solid #ccc;\">First name</th><td style=\"border:1px solid #ccc;\">" . $row["first_name"]. "</td></tr>";
		}
    }
} else {
    echo "0 results";
}
$conn->close();

echo "<table style=\"border:1px solid #ccc;\">".$mycontacts."</table>";

echo "<hr />";

/*######################################## NEW WAY #############################*/

$sql = "SELECT first_name,last_name,people_no FROM people ORDER BY first_name ASC";
//$sql = "SELECT first_name,last_name,people_no FROM people where password = ? AND email = ?";

$mysqli = new mysqli($servername, $username, $password, $dbname);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



if ($stmt = $mysqli->prepare($sql)) {
	
	//$stmt->bind_param("ss", $_REQUEST['pw'], $_REQUEST['em']);
	
    /* execute statement */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($fn,$ln,$pn);

    /* fetch values */
    while ($stmt->fetch()) {
        #printf ("%s (%s)\n", $fn, $ln);
		if ( $fn == "rachel" ) {
			$xmycontacts .= "<tr><th style=\"border:1px solid #ccc; background-color: black; color: white;\">First name</th><td style=\"border:1px solid #ccc; background-color: black; color: white;\">" . $fn. " Boo!</td></tr>";
		} else {
			$xmycontacts .= "<tr><th style=\"border:1px solid #ccc;\">First name</th><td style=\"border:1px solid #ccc;\">" . $fn. "</td></tr>";
		}		
    }

    /* close statement */
    $stmt->close();
}

/* close connection */
$mysqli->close();

echo "<table style=\"border:1px solid #ccc;\">".$xmycontacts."</table>";

?>