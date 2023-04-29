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
                    <th>Criminal ID</th>
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


function makeTable_crime($caseid, $crid, $cname, $classification, $datecharged, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($cname);
    formatInput($classification);

    // Display the search prompt
    echo "<p> Showing Results For: <br>";
    if($caseid !== "") {
        echo "Case ID: " . $caseid . "<br>";
    }
    if($crid !== "") {
        echo "Criminal ID: " . $crid . "<br>";
    }
    if($cname !== "") {
        echo "Criminal Name: " . $cname . "<br>";
    }
    if($classification !== "") {
        echo "Classification: "; 
                    switch($classification) {
                case "o":
                    echo "Other";
                    break;

                case "m":
                    echo "Misdemeanor";
                    break;

                case "f":
                    echo "Felony";
                    break;
            }
        echo "<br>";
    }
    if($datecharged !== "") {
        echo "Date Charged After: " . $datecharged . "<br>";
    }
    echo "</p>";

    // Initialize table
    echo    "<table id=\"Crime\">
                <tr class=\"row-labels\">
                    <th>Case ID</th>
                    <th>Criminal ID</th>
                    <th>First Name</th>
                    <th>Last Name </th>
                    <th>Classification</th>
                    <th>Date Charged</th>
                    <th>Appeal Status</th>
                    <th>Hearing Date</th>
                    <th>Appeal Cutoff Date</th>
                </tr>";

    
    // will show everything if no fields are entered
    $aQuery = "SELECT c.*, cr.c_first AS criminal_first, cr.c_last AS criminal_last FROM crime c JOIN criminal cr ON c.c_id = cr.c_id";

    // Add to query if any fields are entered

    $aQuery .= " WHERE CONCAT(cr.c_first,' ',  cr.c_last) LIKE '%" . $cname . "%'";
    $aQuery .= "AND c.classification LIKE '%" . $classification . "%' ";
    if($datecharged) {
        $aQuery .= "AND c.date_charged >= '" . $datecharged . "'";
    }
    if($caseid) {
        $aQuery .= " AND c.case_id = '" . $caseid . "'";
    }
    if($crid) {
        $aQuery .= " AND c.c_id = '" . $crid . "'";
    }
    $aQuery .= ";";
    
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["case_id"] . "</th>";
            echo "<th>" . $row["c_id"] . "</th>";
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


function makeTable_charge($chargeid, $caseid, $cname, $chargeStat, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($cname);
    formatInput($chargeStat);

    // Display the search prompt
    echo "<p> Showing Results For: <br>";
    if($chargeid !== "") {
        echo "Charge ID: " . $chargeid . "<br>";
    }
    if($caseid !== "") {
        echo "Case ID: " . $caseid . "<br>";
    }
    if($cname !== "") {
        echo "Criminal Name: " . $cname . "<br>";
    }
    if($chargeStat !== "") {
        echo "Charge Status: ";
        switch($chargeStat) {
            case "p":
                echo "Pending";
                break;
            case "g":
                echo "Guilty";
                break;
            case "n":
                echo "Not Guilty";
                break;
        }
        echo "<br>";
    }
    echo "</p>";

    // Initialize table
    echo    "<table id=\"Charge\">
                <tr class=\"row-labels\">
                    <th>Charge ID</th>
                    <th>Case ID</th>
                    <th>First Name</th>
                    <th>Last Name </th>
                    <th>Crime Code</th>
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
    if($chargeid !== "") {
        $aQuery .= " AND ch.charge_id = " . $chargeid;
    }
    if($caseid !== "") {
        $aQuery .= " AND c.case_id = " . $caseid;
    }
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
            echo "<th>" . $row["code_num"] . "</th>";
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
} // makeTable_charge
?>