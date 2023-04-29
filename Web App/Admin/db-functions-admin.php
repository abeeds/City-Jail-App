<?php 

// safety feature
// removes possibility of typing in SQL code into the form
// ignore leading and trailing whitespace
function formatInput(&$string){
    $INVALID_CHARS =
        [",", "?", "!", ":", ";",
         "+", "<", ">", "%", "~",
        "€", "$", "[", "]", "{", "}", "(", ")",
        "@", "&", "#", "*", "„", "'", '"'];
    $string = str_replace($INVALID_CHARS, "", $string);
    $string = trim($string, " ");
}


// returns the MYSQL connection if success
// need to change this so it takes in a parameter once we add in cookies
function connectToDB_admin() {
    $servername = "localhost"; 
    $username = "admin123"; // temporary
    $password = "admin321";
    $dbname = "cityjail";  

    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error) {
        return NULL;
    }
    return $conn;
}

// This function will make the criminals table
function makeTable_criminal($id, $name, $street ,$city, $state, $zip, $phonenum,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($name);
    formatInput($street);
    formatInput($city);
    formatInput($state);

    // Display the search prompt
    echo "<p> Showing Results For: <br>";
    if($id !== "") {
        echo "ID: " . $id . "<br>";
    }
    if($name !== "") {
        echo "Name: " . $name . "<br>";
    }
    if($street !== "") {
        echo "Street: " . $street . "<br>";
    }
    if($city !== "") {
        echo "City: " . $city . "<br>";
    }
    if($state !== "") {
        echo "State: " . $state . "<br>";
    }
    if($zip !== "") {
        echo "Zip Code: " . $zip . "<br>";
    }
    if($phonenum !== "") {
        echo "Phone Number: " . $phonenum . "<br>";
    }
    echo "</p>";

    // Initialize table
    echo    "<table id=\"Criminals\">
                <tr class=\"row-labels\">
                    <th>ID</th>
                    <th>Last</th>
                    <th>First Name</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip Code</th>
                    <th>Phone Number</th>
                    <th>Violent Offender Status</th>
                    <th>Probation Status</th>
                </tr>";

    
    // will show everything if no fields are entered
    $aQuery = "SELECT * FROM criminal c";

    // Add to query if any fields are entered
    $aQuery .= " WHERE ";
    $aQuery .= "CONCAT(c.c_first, ' ',  c.c_last) LIKE '%" . $name . "%' AND ";
    $aQuery .= "c.c_city LIKE '%" . $city . "%' " ;
    $aQuery .= " AND c.c_street LIKE '%" . $street . "%'" ;
    $aQuery .= " AND c.c_state LIKE '%" . $state . "%'" ;
    if($id !== "") {
        $aQuery .= " AND c.c_id = " . $id;
    }
    if($zip !== "") {
        $aQuery .= " AND c.c_zip = " . $zip;
    }
    if($phonenum !== "") {
        $aQuery .= " AND c.c_phone_num = " . $phonenum;
    }
    $aQuery .= ";";


    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["c_id"] . "</th>";
            echo "<th>" . $row["c_last"] . "</th>";
            echo "<th>" . $row["c_first"] . "</th>";
            echo "<th>" . $row["c_street"] . "</th>";
            echo "<th>" . $row["c_city"] . "</th>";
            echo "<th>" . $row["c_state"] . "</th>";
            echo "<th>" . $row["c_zip"] . "</th>";
            echo "<th>" . $row["c_phone_num"] . "</th>";
            if($row["V_status"] === "y") {
                echo "<th>" . "Yes" . "</th>";
            }
            else {
                echo "<th>" . "No" . "</th>";
            }
            
            if($row["P_status"] === "y") {
                echo "<th>" . "Yes" . "</th>";
            }
            else {
                echo "<th>" . "No" . "</th>";
            }
            
            echo "</tr>";
        }
    }
    echo "</table>";
}
// This function will make the criminals table
function makeTable_officer($bNum, $name, $precinct ,$phonenum, $status,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($name);
    formatInput($status);

    // Display the search prompt
    echo "<p> Showing Results For: <br>";
    if($bNum !== "") {
        echo "Badge Number: " . $bNum . "<br>";
    }
    if($name !== "") {
        echo "Name: " . $name . "<br>";
    }
    if($precinct !== "") {
        echo "Precinct: " . $precinct . "<br>";
    }
    if($status !== "") {
        echo "Status: " . $status . "<br>";
    }
    if($phonenum !== "") {
        echo "Phone Number: " . $phonenum . "<br>";
    }
    echo "</p>";

    // Initialize table
    echo    "<table id=\"officer\">
                <tr class=\"row-labels\">
                    <th> Badge Number </th>
                    <th> First Name </th>
                    <th> Last Name </th>
                    <th> Precinct </th>
                    <th>Phone Number</th>
                    <th> Status </th>
                </tr>";

    
    // will show everything if no fields are entered
    $aQuery = " SELECT * FROM officer o ";

    // Add to query if any fields are entered
    $aQuery .= " WHERE ";
    $aQuery .= " CONCAT(o.o_first, ' ',  o.o_last) LIKE '%" . $name . "%' ";
    $aQuery .= " AND o.o_status LIKE '%" . $status . "%'" ;
    if($bNum !== "") {
        $aQuery .= " AND o.badge_number = " . $bNum;
    }
    if($precinct !== "") {
        $aQuery .= " AND o.o_precinct = " . $precinct;
    }
    if($phonenum !== "") {
        $aQuery .= " AND o.o_phone_number = " . $phonenum;
    }
    $aQuery .= ";";

    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["badge_number"] . "</th>";
            echo "<th>" . $row["o_first"] . "</th>";
            echo "<th>" . $row["o_last"] . "</th>";
            echo "<th>" . $row["o_precinct"] . "</th>";
            echo "<th>" . $row["o_phone_number"] . "</th>";
            if($row["o_status"] === "a") {
                echo "<th>" . "Active" . "</th>";
            }
            else {
                echo "<th>" . "Inactive" . "</th>";
            }  
            echo "</tr>";
        }
    }
    echo "</table>";
}

?>