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


// This function will make the criminals table
function makeTable_criminal($name, $city, $state, $zip, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($name);
    formatInput($city);
    formatInput($state);

    // Display the search prompt
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

    // Initialize table
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

    
    // will show everything if no fields are entered
    $aQuery = "SELECT * FROM criminal c";

    // Add to query if any fields are entered
    //if($name !== "" || $city !== "" || $state !== "" || $zip !== "") {
        $aQuery .= " WHERE ";
        $aQuery .= "CONCAT(c.c_first, ' ',  c.c_last) LIKE '%" . $name . "%' AND ";
        $aQuery .= "c.c_city LIKE '%" . $city . "%' " ;
        $aQuery .= " AND c.c_state LIKE '%" . $state . "%'" ;
        if($zip !== "") {
            $aQuery .= " AND c.c_zip = " . $zip;
        }
        $aQuery .= ";";
    //}

    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
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
// This function will make the criminals table
function makeTable_crime($caseid, $classification, $datecharged, $appealstat, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($caseid);
    formatInput($classification);
    formatInput($appealstat);

    // Display the search prompt
    echo "<p> Showing Results For: <br>";
    if($caseid !== "") {
        echo "Case ID: " . $caseid . "<br>";
    }
    if($classification !== "") {
        echo "Classification: " . $classification . "<br>";
    }
    if($datecharged !== "") {
        echo "Date Charged: " . $datecharged . "<br>";
    }
    if($appealstat !== "") {
        echo "Appeal Status: " . $appealstat . "<br>";
    }
    echo "</p>";

    // Initialize table
    echo    "<table id=\"Crime\">
                <tr class=\"row-labels\">
                    <th>Case ID</th>
                    <th>Criminal ID</th>
                    <th>Classification</th>
                    <th>Date Charged</th>
                    <th>Appeal Status</th>
                    <th>Hearing Date</th>
                    <th>Appeal Cutoff Date</th>
                </tr>";

    
    // will show everything if no fields are entered
    $aQuery = "SELECT * FROM crime c";

    // Add to query if any fields are entered
    if($caseid !== "" || $classification !== "" || $datecharged !== "" || $appealstat !== "") {
        $aQuery .= " WHERE ";
        $aQuery .= "c.case_id LIKE '%" . $caseid . "%' AND ";
        $aQuery .= "c.classification LIKE '%" . $classification . "%' " ;
        $aQuery .= " AND c.date_charged LIKE '%" . $datecharged . "%'" ;
        $aQuery .= " AND c.appeal_status LIKE '%" . $appealstat . "%'" ;
        $aQuery .= ";";
    }

    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["case_id"] . "</th>";
            echo "<th>" . $row["c_id"] . "</th>";
            echo "<th>" . $row["classification"] . "</th>";
            echo "<th>" . $row["date_charged"] . "</th>";
            echo "<th>" . $row["appeal_status"] . "</th>";
            echo "<th>" . $row["hearing_date"] . "</th>";
            echo "<th>" . $row["appeal_cutoff_date"] . "</th>";
            
            echo "</tr>";
        }
    }
    echo "</table>";
}
?>