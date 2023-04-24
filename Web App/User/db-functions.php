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

function connectToDB_guest() {
    $servername = "localhost"; 
    $username = "guest";
    $password = "guest";
    $dbname = "cityjail";  

    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error) {
        return NULL;
    }
    return $conn;
}

function makeTable_criminal($name, $city, $state, $zip, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // making upper most row with labels
    formatInput($name);
    formatInput($city);
    formatInput($state);
    echo "<p> Showing Results For: <br>";
    if($name !== "") {
        echo "Name: " . $name . "<br>";
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

    echo "</p>";

    // row with labels
    echo    "<table id=\"Criminals\">
                <tr class=\"row-labels\">
                    <th>ID</th>
                    <th>Last</th>
                    <th>First Name</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip Code</th>
                    <th>Violent Offender Status</th>
                    <th>Probation Status</th>
                </tr>";
    $aQuery = "SELECT * FROM criminal c";
    

    // add WHERE clause as long as one field is present
    if($name !== "" || $city !== "" || $state !== "" || $zip !== "") {
        $aQuery .= " WHERE ";
        $aQuery .= "CONCAT(c.c_first, ' ',  c.c_last) LIKE '%" . $name . "%' AND ";
        $aQuery .= "c.c_city LIKE '%" . $city . "%' " ;
        $aQuery .= " AND c.c_state LIKE '%" . $state . "%'" ;
        if($zip !== "") {
            $aQuery .= " AND c.c_zip = " . $zip;
        }
        $aQuery .= ";";
    }

    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["c_id"] . "</th>";
            echo "<th>" . $row["c_last"] . "</th>";
            echo "<th>" . $row["c_first"] . "</th>";
            echo "<th>" . $row["c_city"] . "</th>";
            echo "<th>" . $row["c_state"] . "</th>";
            echo "<th>" . $row["c_zip"] . "</th>";
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
?>