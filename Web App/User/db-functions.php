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

// change date from mm/dd/yyyy to yyyy-mm-dd
function formatDate(&$date) {
    if($date !== "") {
        $date_parts = explode('/', $date);
        $date = $date_parts[2] .  $date_parts[0] .  $date_parts[1];
    }
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
    $aQuery .= " WHERE CONCAT(c.c_first, ' ',  c.c_last) LIKE '%" . $name . "%' AND ";
    $aQuery .= "c.c_city LIKE '%" . $city . "%' " ;
    $aQuery .= " AND c.c_state LIKE '%" . $state . "%'" ;
    if($zip !== "") {
        $aQuery .= " AND c.c_zip = " . $zip;
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
} // makeTable_criminal($name, $city, $state, $zip, $database=NULL)


// This function will make the criminals table
function makeTable_crime($cname, $classification, $datecharged, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($cname);
    formatInput($classification);
    formatDate($datecharged);

    // Display the search prompt
    echo "<p> Showing Results For: <br>";
    if($cname !== "") {
        echo "Criminal Name: " . $cname . "<br>";
    }
    if($classification !== "") {
        echo "Classification: " . $classification . "<br>";
    }
    if($datecharged !== "") {
        echo "Date Charged: " . $datecharged . "<br>";
    }
    echo "</p>";

    // Initialize table
    echo    "<table id=\"Crime\">
                <tr class=\"row-labels\">
                    <th>Case ID</th>
                    <th>First Name</th>
                    <th>Last Name </th>
                    <th>Classification</th>
                    <th>Date Charged</th>
                    <th>Appeal Status</th>
                    <th>Hearing Date</th>
                    <th>Appeal Cutoff Date</th>
                </tr>";

    
    // will show everything if no fields are entered
    $aQuery = "SELECT c.*, cr.c_first AS criminal_first, cr.c_last AS criminal_last FROM crime c JOIN criminal cr ON c.c_id = cr.c_id ";

    // Add to query if any fields are entered

    $aQuery .= "WHERE CONCAT(cr.c_first,' ',  cr.c_last) LIKE '%" . $cname . "%' ";
    $aQuery .= "AND c.classification LIKE '%" . $classification . "%' ";
    if($datecharged) {
        $aQuery .= "AND c.date_charged >= '" . $datecharged . "'";
    }
    $aQuery .= ";";
    
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["case_id"] . "</th>";
            echo "<th>" . $row["criminal_first"] . "</th>";
            echo "<th>" . $row["criminal_last"] . "</th>";
            switch($row["classification"]) {
                case "o":
                    echo "<th>Other</th>";
                    break;

                case "m":
                    echo "<th>Misdemeanor</th>";
                    break;

                case "f":
                    echo "<th>Felony</th>";
                    break;
            }
            echo "<th>" . $row["date_charged"] . "</th>";
            switch($row["appeal_status"]) {
                case "ia":
                    echo "<th>In Appeal</th>";
                    break;

                case "ca":
                    echo "<th>Can Appeal</th>";
                    break;

                case "c":
                    echo "<th>Closed</th>";
                    break;
            }
            echo "<th>" . $row["hearing_date"] . "</th>";
            echo "<th>" . $row["appeal_cutoff_date"] . "</th>";
            echo "</tr>";
        }
    }
    echo "</table>";
} // makeTable_crime($cname, $classification, $datecharged, $database=NULL)

function makeTable_sentence($name, $start_date, $end_date, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($name);
    formatDate($startdate);
    formatDate($enddate);


    // Display the search prompt
    echo "<p> Showing Results For: <br>";
    if($name !== "") {
        echo "Name: " . $name . "<br>";
    }
    if($start_date !== "") {
        echo "Start Date: " . $start_date . "<br>";
    }
    if($end_date !== "") {
        echo "End Date: " . $end_date . "<br>";
    }
    echo "</p>";

    // Initialize table
    echo    "<table id=\"Sentences\">
                <tr class=\"row-labels\">
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Sentence ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Number of Violations</th>
                    <th>Type</th>
                </tr>";


    // will show everything if no fields are entered
    $aQuery = "SELECT s.*, cr.c_first AS criminal_first, cr.c_last AS criminal_last FROM sentence s JOIN criminal cr ON s.c_id = cr.c_id";

    // Add to query if any fields are entered
    $aQuery .= " AND CONCAT(cr.c_first, ' ',  cr.c_last) LIKE '%" . $name . "%' ";
    if($start_date) {
        $aQuery .= "AND s.start_date >= '" . $start_date . "'";
    }
    if($end_date) {
        $aQuery .= " AND s.end_date <= '" . $end_date . "'";
    }
    $aQuery .= ";";
    //echo "<p>$aQuery</p>";

    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["c_id"] . "</th>";
            echo "<th>" . $row["criminal_first"] . "</th>";
            echo "<th>" . $row["criminal_last"] . "</th>";
            echo "<th>" . $row["sentence_id"] . "</th>";
            echo "<th>" . $row["start_date"] . "</th>";
            echo "<th>" . $row["end_date"] . "</th>";
            echo "<th>" . $row["num_violations"] . "</th>";
            if($row["type"] === "j") {
                echo "<th>" . "Jail" . "</th>";
            }
            else if($row["type"] === "h"){
                echo "<th>" . "House Arrest" . "</th>";
            }
            else {
                echo "<th>" . "Probation" . "</th>";
            }

            echo "</tr>";
        }
    }
    echo "</table>";
}
// This function will make the charges table
function makeTable_charge($cname, $chargeStat, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($cname);
    formatInput($chargeStat);

    // Display the search prompt
    echo "<p> Showing Results For: <br>";
    if($cname !== "") {
        echo "Criminal Name: " . $cname . "<br>";
    }
    if($chargeStat !== "") {
        echo "Charge Status: " . $chargeStat . "<br>";
    }
    echo "</p>";

    // Initialize table
    echo    "<table id=\"Charge\">
                <tr class=\"row-labels\">
                    <th>Charge ID</th>
                    <th>Case ID</th>
                    <th>First Name</th>
                    <th>Last Name </th>
                    <th>Charge Status</th>
                    <th>Fine Amount</th>
                    <th>Court Fee</th>
                    <th>Amount Paid</th>
                    <th>Payment Date</th>
                </tr>";

    // will show everything if no fields are entered
    $aQuery = "SELECT ch.*, cr.c_first AS criminal_first, cr.c_last AS criminal_last FROM charge ch JOIN crime c ON ch.case_id = c.case_id JOIN criminal cr ON c.c_id = cr.c_id ";
    
    // Add to query if any fields are entered
    $aQuery .= "WHERE CONCAT(cr.c_first,' ',  cr.c_last) LIKE '%" . $cname . "%'";
    $aQuery .= "AND ch.charge_status LIKE '%" . $chargeStat . "%' ";
    $aQuery .= ";";


    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["charge_id"] . "</th>";
            echo "<th>" . $row["case_id"] . "</th>";
            echo "<th>" . $row["criminal_first"] . "</th>";
            echo "<th>" . $row["criminal_last"] . "</th>";
            switch($row["charge_status"]) {
                case "p":
                    echo "<th>Pending</th>";
                    break;

                case "g":
                    echo "<th>Guilty</th>";
                    break;

                case "n":
                    echo "<th>Not Guilty</th>";
                    break;
            }
            echo "<th>" . $row["fine_amount"] . "</th>";
            echo "<th>" . $row["court_fee"] . "</th>";
            echo "<th>" . $row["amount_paid"] . "</th>";
            echo "<th>" . $row["payment_date"] . "</th>";
            echo "</tr>";
        }
    }
    echo "</table>";
} // makeTable_crime($cname, $chargeStat $database=NULL)
?>
