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
    $servername = "18.188.82.70"; 
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
// This function will make the criminals table
function makeTable_prob_officer($pid, $name, $street ,$city, $state, $zip, $phonenum,$email, $status,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($name);
    formatInput($street);
    formatInput($city);
    formatInput($state);
    formatInput($status);

    // Display the search prompt
    echo "<p> Showing Results For: <br>";
    if($pid !== "") {
        echo "ID: " . $pid . "<br>";
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
    if($email !== "") {
        echo "Email " . $email . "<br>";
    }
    if($status !== "") {
        echo "Status: " . $status . "<br>";
    }
    if($phonenum !== "") {
        echo "Phone Number: " . $phonenum . "<br>";
    }
    echo "</p>";

    // Initialize table
    echo    "<table class =\"show-table\" id=\"officer\">
                <tr class=\"row-labels\">
                    <th> Probation Officer ID </th>
                    <th> First Name </th>
                    <th> Last Name </th>
                    <th> Phone Number </th>
                    <th> Street</th>
                    <th> City </th>
                    <th> State </th>
                    <th> Zip </th>
                    <th> Email </th>
                    <th> Status </th>
                </tr>";

    
    // will show everything if no fields are entered
    $aQuery = "SELECT po.* FROM prob_officer po";

    // Add to query if any fields are entered
    $aQuery .= " WHERE ";
    $aQuery .= " CONCAT(po.p_first, ' ',  po.p_last) LIKE '%" . $name . "%' AND ";
    $aQuery .= "po.p_city LIKE '%" . $city . "%' " ;
    $aQuery .= " AND po.p_street LIKE '%" . $street . "%'" ;
    $aQuery .= " AND po.p_state LIKE '%" . $state . "%'" ;
    $aQuery .= " AND po.p_email LIKE '%" . $email . "%'" ;
    $aQuery .= " AND po.p_status LIKE '%" . $status . "%'" ;
    if($pid !== "") {
        $aQuery .= " AND po.p_id = " . $pid;
    }
    if($zip !== "") {
        $aQuery .= " AND po.p_zip = " . $zip;
    }
    if($phonenum !== "") {
        $aQuery .= " AND po.p_phone_number = " . $phonenum;
    }
    $aQuery .= ";";

    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["p_id"] . "</th>";
            echo "<th>" . $row["p_first"] . "</th>";
            echo "<th>" . $row["p_last"] . "</th>";
            echo "<th>" . $row["p_phone_number"] . "</th>";
            echo "<th>" . $row["p_street"] . "</th>";
            echo "<th>" . $row["p_city"] . "</th>";
            echo "<th>" . $row["p_state"] . "</th>";
            echo "<th>" . $row["p_zip"] . "</th>";
            echo "<th>" . $row["p_email"] . "</th>";
            if($row["p_status"] === "a") {
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

// This function will make the officer table
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
                    <th> Phone Number </th>
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

function show_officer($database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }
    // Initialize table
    echo    "<table class =\"show-table\" id=\"officer\">
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
}// show_officer
function show_prob_officer($database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }
    // Initialize table
    echo    "<table class =\"show-table\" id=\"officer\">
                <tr class=\"row-labels\">
                    <th> Probation Officer ID </th>
                    <th> First Name </th>
                    <th> Last Name </th>
                    <th> Phone Number </th>
                    <th> Street</th>
                    <th> City </th>
                    <th> State </th>
                    <th> Zip </th>
                    <th> Email </th>
                    <th> Status </th>
                </tr>";

    
    // will show everything if no fields are entered
    $aQuery = " SELECT * FROM prob_officer o ";
    $aQuery .= ";";

    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["p_id"] . "</th>";
            echo "<th>" . $row["p_first"] . "</th>";
            echo "<th>" . $row["p_last"] . "</th>";
            echo "<th>" . $row["p_phone_number"] . "</th>";
            echo "<th>" . $row["p_street"] . "</th>";
            echo "<th>" . $row["p_city"] . "</th>";
            echo "<th>" . $row["p_state"] . "</th>";
            echo "<th>" . $row["p_zip"] . "</th>";
            echo "<th>" . $row["p_email"] . "</th>";
            if($row["p_status"] === "a") {
                echo "<th>" . "Active" . "</th>";
            }
            else {
                echo "<th>" . "Inactive" . "</th>";
            }  
            echo "</tr>";
        }
    }
    echo "</table>";
}// show_officer
function show_crime_officer($database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }
    // Initialize table
    echo    "<table class =\"show-table\" id=\"officer\">
                <tr class=\"row-labels\">
                    <th> Case ID </th>
                    <th> Badge Number</th>
                    <th> First Name </th>
                    <th> Last Name </th>
                    <th> Classification </th>
                </tr>";

    
    // will show everything if no fields are entered
    $aQuery = " SELECT co.* , o.o_last AS last, o.o_first AS first, c.classification AS class FROM crime_officer co, officer o, crime c WHERE o.badge_number = co.badge_number AND c.case_id = co.case_id";
    $aQuery .= ";";

    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["case_id"] . "</th>";
            echo "<th>" . $row["badge_number"] . "</th>";
            echo "<th>" . $row["first"] . "</th>";
            echo "<th>" . $row["last"] . "</th>";
            switch($row["class"]) {
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
            echo "</tr>";
        }
    }
    echo "</table>";
}// show_officer
function show_criminal($database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }
    // Initialize table
    echo    "<table id=\"Criminals\">
                <tr class=\"row-labels\">
                    <th>Known Alias</th>
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
    $aQuery = " SELECT  c.*,  GROUP_CONCAT(DISTINCT a.alias) AS Alias FROM criminal c LEFT JOIN alias a ON a.c_id = c.c_id GROUP BY c.c_id";
    $aQuery .= ";";
    //$aQuery = " SELECT c.* FROM criminal c ";
    //$aQuery .= ";";
    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            if($row["Alias"] !== NULL) {
                echo "<th>" . "Yes" . "</th>";
            }
            else {
                echo "<th>" . "No" . "</th>";
            }
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
}// show_criminal
function show_sentence($database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }
    // Initialize table
    echo    "<table id=\"Sentences\">
                <tr class=\"row-labels\">
                    <th>Sentence ID</th>
                    <th>Criminal ID</th>
                    <th>Probation Officer ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Number of Violations</th>
                    <th>Type</th>
                </tr>";

    
    // will show everything if no fields are entered
    $aQuery = " SELECT s.*, a.alias AS Alias FROM sentence s , alias a WHERE a.c_id = s.c_id";
    $aQuery .= ";";

    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["sentence_id"] . "</th>";
            echo "<th>" . $row["Alias"] . "</th>";
            echo "<th>" . $row["p_id"] . "</th>";
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
}// show_sentence
function show_charge($database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }
   // Initialize table
   echo    "<table id=\"Charge\">
                <tr class=\"row-labels\">
                    <th>Charge ID</th>
                    <th>Case ID</th>
                    <th>Crime Code Description</th>
                    <th>Charge Status</th>
                    <th>Fine Amount</th>
                    <th>Court Fee</th>
                    <th>Amount Paid</th>
                    <th>Payment Date</th>
                </tr>";

    
    // will show everything if no fields are entered
    $aQuery = " SELECT c.*, cc.code_desc AS Crime_code FROM charge c , crime_code cc WHERE cc.code_num = c.code_num";
    $aQuery .= ";";

    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["charge_id"] . "</th>";
            echo "<th>" . $row["case_id"] . "</th>";
            echo "<th>" . $row["Crime_code"] . "</th>";
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
}// show_charge
function show_appeal($database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }
    // Initialize table
    echo    "<table id=\"Appeals\">
                <tr class=\"row-labels\">
                    <th>Case ID</th>
                    <th>Attempt Number</th>
                    <th>Filing Date</th>
                    <th>Appeal Hearing Date</th>
                    <th>Result</th>
                </tr>";


    // will show everything if no fields are entered
    $aQuery = "SELECT * FROM appeal a";

    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["case_id"] . "</th>";
            echo "<th>" . $row["attempt_num"] . "</th>";
            echo "<th>" . $row["filing_date"] . "</th>";
            echo "<th>" . $row["appeal_hearing_date"] . "</th>";
            if($row["result_status"] === "p") {
                echo "<th>" . "Pending" . "</th>";
            }
            else if($row["result_status"] === "a"){
                echo "<th>" . "Approved" . "</th>";
            }
            else {
                echo "<th>" . "Disapproved" . "</th>";
            }

            echo "</tr>";
        }
    }
    echo "</table>";
} // show_appeal
/*
function select_officer($bNum,$database=NULL ){
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }
    // Initialize table
    echo    "<table class =\"show-table\" id=\"officer\">
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
    if($bNum !== "") {
        $aQuery .= " WHERE o.badge_number = " . $bNum;
    }
    $aQuery .= ";";
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
*/
function show_crime($database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }
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
    $aQuery = " SELECT * FROM crime c ";
    $aQuery .= ";";

    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["case_id"] . "</th>";
            echo "<th>" . $row["c_id"] . "</th>";
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
}// show_officer
// This function will add officers
function add_officer($bNum, $fname, $lname, $precinct ,$phonenum, $status,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($fname);
    formatInput($lname);
    formatInput($status);
    
    $aQuery = " INSERT INTO officer (badge_number, o_last, o_first, o_precinct, o_phone_number, o_status)
    VALUES";

    // Add to query if any fields are entered
    $aQuery .= " (  $bNum  , ";
    $aQuery .= " \"$lname\" ,";
    $aQuery .= " \"$fname\" ,";
    $aQuery .= " $precinct  ,";
    $aQuery .= "  $phonenum  ,";
    $aQuery .= " \"$status\" )";

    $aQuery .= ";";
    //echo "<p>$aQuery</p>";
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Insert successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
}
// This function will add Probation officers
function add_prob_officer($pid, $lname, $fname, $street ,$city, $state, $zip, $phonenum, $email, $status,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($fname);
    formatInput($lname);
    formatInput($street);
    formatInput($city);
    formatInput($state);
    formatInput($status);
    
    $aQuery = " INSERT INTO prob_officer (p_id, p_last, p_first, p_phone_number, p_street,p_city, p_state, p_zip, p_email, p_status)
    VALUES";

    // Add to query if any fields are entered
    $aQuery .= " (  $pid  , ";
    $aQuery .= " \"$lname\" ,";
    $aQuery .= " \"$fname\" ,";
    $aQuery .= " $phonenum  ,";
    $aQuery .= "  \"$street\"  ,";
    $aQuery .= " \"$city\" ,";
    $aQuery .= "  \"$state\"  ,";
    $aQuery .= "  $zip ,";
    $aQuery .= "  \"$email\"  ,";
    $aQuery .= "  \"$status\"  )";

    $aQuery .= ";";
    echo "<p>$aQuery</p>";
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Insert successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
}
//This function will add criminals
function add_criminal($id, $lname, $fname, $street ,$city, $state, $zip, $phonenum, $Pstat, $Vstat,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($fname);
    formatInput($lname);
    formatInput($street);
    formatInput($city);
    formatInput($state);
    
    $aQuery = " INSERT INTO criminal (c_id, c_last, c_first, c_street, c_city, c_state, c_zip, c_phone_num, V_status, P_status)
    VALUES";

    // Add to query if any fields are entered
    $aQuery .= " (  $id  , ";
    $aQuery .= " \"$lname\" ,";
    $aQuery .= " \"$fname\" ,";
    $aQuery .= " \"$street\"  ,";
    $aQuery .= "  \"$city\"  ,";
    $aQuery .= "  \"$state\"  ,";
    $aQuery .= " $zip ,";
    $aQuery .= " $phonenum ,";
    $aQuery .= " \"$Vstats\" ,";
    $aQuery .= " \"$Pstats\" )";

    $aQuery .= ";";
    //echo "<p>$aQuery</p>";
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Insert successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
}
//This function will add sentences
function add_sentence($sid, $cid, $probid, $start_date ,$end_date, $numVio, $type,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($type);
    
    
    $aQuery = " INSERT INTO sentence (sentence_id, c_id, p_id, start_date, end_date, num_violations, type)
    VALUES";

    // Add to query if any fields are entered
    $aQuery .= " (  $sid  , ";
    $aQuery .= " $cid ,";
    $aQuery .= " $probid ,";
    $aQuery .= " \"$start_date\"  ,";
    $aQuery .= "  \"$end_date\"  ,";
    $aQuery .= "  $numVio  ,";
    $aQuery .= " \"$type\" )";

    $aQuery .= ";";
    echo "<p>$aQuery</p>";
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Insert successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
}
function update_officer($bNum, $fname, $lname, $precinct ,$phonenum, $status,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($fname);
    formatInput($lname);
    formatInput($status);
    
    $aQuery = " UPDATE officer SET";
    if($lname !== "") {
        $aQuery .= " o_last  =  \"$lname\" ";
    }
    if($fname !== "") {
        $aQuery .= " o_first  =  \"$fname\" ";
    }
    if($precinct !== "") {
        $aQuery .= " o_precinct  =  $precinct ";
    }
    if($phonenum !== "") {
        $aQuery .= " o_phone_number  =  $phonenum ";
    }
    if($status !== "") {
        $aQuery .= " o_status  =  \"$status\" ";
    }
    if($bNum !== "") {
        $aQuery .= " WHERE badge_number = " . $bNum;
    }
    $aQuery .= " ; ";
    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Update successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
}
function update_criminal($id, $lname, $fname, $street ,$city, $state, $zip, $phonenum, $Pstat, $Vstat,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($fname);
    formatInput($lname);
    formatInput($street);
    formatInput($city);
    formatInput($state);
    
    $aQuery = " UPDATE criminal SET";
    if($lname !== "") {
        $aQuery .= " c_last  =  \"$lname\", ";
    }
    if($fname !== "") {
        $aQuery .= " c_first  =  \"$fname\", ";
    }
    if($street !== "") {
        $aQuery .= " c_street  = \"$street\", ";
    }
    if($city !== "") {
        $aQuery .= " c_city  = \"$city\" ,";
    }
    if($state !== "") {
        $aQuery .= " c_state  = \"$state\", ";
    }
    if($zip !== "") {
        $aQuery .= " c_zip  = $zip, ";
    }
    if($phonenum !== "") {
        $aQuery .= " c_phone_num  =  $phonenum ,";
    }
    if($Vstat !== "") {
        $aQuery .= " V_status  =  \"$Vstat\", ";
    }
    if($Pstat !== "") {
        $aQuery .= " P_status  =  \"$Pstat\", ";
    }
    $aQuery = rtrim($aQuery, ', ') . " WHERE c_id = $id";
    $aQuery .= " ; ";
    echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Update successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
}
function update_prob_officer($pid, $lname, $fname, $street ,$city, $state, $zip, $phonenum, $email, $status,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($fname);
    formatInput($lname);
    formatInput($street);
    formatInput($city);
    formatInput($state);
    
    $aQuery = " UPDATE prob_officer SET";
    if($lname !== "") {
        $aQuery .= " p_last  =  \"$lname\" ";
    }
    if($fname !== "") {
        $aQuery .= " p_first  =  \"$fname\" ";
    }
    if($street !== "") {
        $aQuery .= " p_street  = \"$street\" ";
    }
    if($city !== "") {
        $aQuery .= " p_city  = \"$city\" ";
    }
    if($state !== "") {
        $aQuery .= " p_state  = \"$state\" ";
    }
    if($zip !== "") {
        $aQuery .= " p_zip  = $zip ";
    }
    if($phonenum !== "") {
        $aQuery .= " p_phone_number  =  $phonenum ";
    }
    if($email !== "") {
        $aQuery .= " p_email  =  \"$email\" ";
    }
    if($status !== "") {
        $aQuery .= " p_status  =  \"$status\" ";
    }
    if($pid !== "") {
        $aQuery .= " WHERE p_id = " . $pid;
    }
    $aQuery .= " ; ";
    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Update successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
}
function update_charge($chargeid, $caseid, $codenum, $chargeStat ,$fine, $court, $paid, $paymentdate,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($chargeStat);
    
    $aQuery = " UPDATE charge SET";
    if($caseid !== "") {
        $aQuery .= " case_id  =  $caseid ";
    }
    if($chargeStat !== "") {
        $aQuery .= " charge_status  =  \"$chargeStat\" ";
    }
    if($codenum !== "") {
        $aQuery .= " code_num  =  $codenum ";
    }
    if($fine !== "") {
        $aQuery .= "fine_amount  =  $fine ";
    }
    if($court !== "") {
        $aQuery .= " court_fee  =  $court ";
    }
    if($paid !== "") {
        $aQuery .= " amount_paid  =  $paid ";
    }
    if($paymentdate !== "") {
        $aQuery .= " payment_date  =  \"$paymentdate\" ";
    }
    if($chargeid !== "") {
        $aQuery .= " WHERE charge_id = " . $chargeid;
    }
    $aQuery .= " ; ";
    echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Update successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error </p>";
    }
}

function delete_officer($bNum, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    $aQuery = " DELETE FROM officer ";
    if($bNum !== "") {
        $aQuery .= " WHERE badge_number = " . $bNum;
    }
    $aQuery .= " ; ";
    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Delete successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
}
function delete_prob_officer($pid, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    $aQuery = " DELETE FROM prob_officer ";
    if($pid !== "") {
        $aQuery .= " WHERE p_id = " . $pid;
    }
    $aQuery .= " ; ";
    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Delete successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
}
function delete_criminal($cid, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    $aQuery = " DELETE FROM criminal ";
    if($cid !== "") {
        $aQuery .= " WHERE c_id = " . $cid;
    }
    $aQuery .= " ; ";
    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Delete successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
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
function update_crime($caseid, $crid, $classification, $datecharged, $appealStat, $hearingdate, $appealcut,  $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($classification);
    
    $aQuery = " UPDATE crime SET";
    if($crid !== "") {
        $aQuery .= " c_id  =  $crid ";
    }
    if($classification !== "") {
        $aQuery .= " classification  =  \"$classification\" ";
    }
    if($datecharged !== "") {
        $aQuery .= " datecharged  =  $datecharged ";
    }
    if($appealStat !== "") {
        $aQuery .= " appeal_status  =  \"$appealStat\" ";
    }
    if($hearingdate !== "") {
        $aQuery .= " hearing_date  =  $hearingdate ";
    }
    if($appealcut !== "") {
        $aQuery .= " appeal_cutoff_date  =  $appealcut ";
    }
    if($caseid !== "") {
        $aQuery .= " WHERE case_id = " . $caseid;
    }
    $aQuery .= " ; ";
    //echo "<p>$aQuery</p>";
    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Update successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
}
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

function makeTable_sentence($sid, $cid, $name, $start_date, $end_date, $type, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($name);

    // Display the search prompt
    echo "<p> Showing Results For: <br>";
    if($sid !== "") {
        echo "Sentence ID: " . $sid . "<br>";
    }
    if($cid !== "") {
        echo "Criminal ID: " . $cid . "<br>";
    }
    if($name !== "") {
        echo "Name: " . $name . "<br>";
    }
    if($start_date !== "") {
        echo "Start Date: " . $start_date . "<br>";
    }
    if($end_date !== "") {
        echo "End Date: " . $end_date . "<br>";
    }
    if($type !== "") {
        echo "Sentence Type: ";
        if($type === "j") {
            echo "Jail";
        }
        else if($type === "h"){
            echo "House Arrest";
        }
        else {
            echo "Probation";
        }
        echo "<br>";
    }
    echo "</p>";

    // Initialize table
    echo    "<table id=\"Sentences\">
                <tr class=\"row-labels\">
                    <th>Sentence ID</th>
                    <th>Criminal ID</th>
                    <th>Last</th>
                    <th>First</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Number of Violations</th>
                    <th>Type</th>
                </tr>";


    // will show everything if no fields are entered
    $aQuery = "SELECT * FROM sentence s, criminal c";

    // Add to query if any fields are entered
    $aQuery .= " WHERE c.c_id = s.c_id ";
    $aQuery .= "AND CONCAT(c.c_first, ' ',  c.c_last) LIKE '%" . $name . "%' ";
    if($start_date !== "" && $end_date === "") {
        $aQuery .= " AND s.start_date = '" . $start_date . "'";
    }
    elseif($end_date !== "" && $start_date === "") {
        $aQuery .= " AND s.end_date = '" . $end_date . "'";
    }
    elseif($start_date !== "" && $end_date !== "") {
        $aQuery .= " AND s.start_date >= '" . $start_date . "'";
        $aQuery .= " AND s.end_date <= '" . $end_date . "'";
    }
    if($type !== "") {
        $aQuery .= " AND s.type = '${type}' ";
    }
    if($sid !== "") {
        $aQuery .= " AND s.sentence_id = '${sid}' ";
    }
    if($cid !== "") {
        $aQuery .= " AND c.c_id = '${cid}' ";
    }

    $aQuery .= ";";


    // adds a row to the HTML for each row on the table
    // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
    $result = $database->query($aQuery);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th>" . $row["sentence_id"] . "</th>";
            echo "<th>" . $row["c_id"] . "</th>";
            echo "<th>" . $row["c_last"] . "</th>";
            echo "<th>" . $row["c_first"] . "</th>";
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
}// makeTable_sentence

function makeTable_appeal($cname, $appeal_date, $resultStat, $database=NULL) {
    if(!$database) {
        echo "<p> Failed to connect to database. </p>";
        return;
    }

    // Ensure that no improper characters are being used
    formatInput($cname);

    // Display the search prompt
    echo "<p> Showing Results For: <br>";
    if($cname !== "") {
        echo "Name: " . $cname . "<br>";
    }
    if($appeal_date !== "") {
        echo "Appeal Hearing Date: " . $appeal_date . "<br>";
    }
    if($resultStat !== "") {
        echo "Result: ";
        if($resultStat === "p") {
            echo "Pending";
        }
        else if($resultStat === "a"){
            echo "Approved";
        }
        else {
            echo "Disapproved";
        }
        echo "<br>";
    }
    echo "</p>";

    // Initialize table
    echo    "<table id=\"Appeals\">
                <tr class=\"row-labels\">
                    <th>Case ID</th>
                    <th>ID</th>
                    <th>Last</th>
                    <th>First</th>
                    <th>Filing Date</th>
                    <th>Appeal Hearing Date</th>
                    <th>Attempt Number</th>
                    <th>Result</th>
                </tr>";


    // will show everything if no fields are entered
    $aQuery = "SELECT * FROM appeal a, crime ca, criminal c ";

    // Add to query if any fields are entered
    $aQuery .= "WHERE c.c_id = ca.c_id AND ca.case_id = a.case_id ";
    $aQuery .= "AND CONCAT(c.c_first, ' ',  c.c_last) LIKE '%" . $name . "%' ";
    $aQuery .= "AND a.appeal_hearing_date LIKE '%" . $appeal_date . "%' " ;
    if($resultStat !== "") {
        $aQuery .= " AND a.result_status = '${resultStat}' ";
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
            echo "<th>" . $row["c_last"] . "</th>";
            echo "<th>" . $row["c_first"] . "</th>";
            echo "<th>" . $row["filing_date"] . "</th>";
            echo "<th>" . $row["appeal_hearing_date"] . "</th>";
            echo "<th>" . $row["attempt_num"] . "</th>";
            if($row["result_status"] === "p") {
                echo "<th>" . "Pending" . "</th>";
            }
            else if($row["result_status"] === "a"){
                echo "<th>" . "Approved" . "</th>";
            }
            else {
                echo "<th>" . "Disapproved" . "</th>";
            }

            echo "</tr>";
        }
    }
    echo "</table>";
}
?>
