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
}
// function select_officer($bNum,$database=NULL ){
//     if(!$database) {
//         echo "<p> Failed to connect to database. </p>";
//         return;
//     }
//     // Initialize table
//     echo    "<table class =\"show-table\" id=\"officer\">
//                 <tr class=\"row-labels\">
//                     <th> Badge Number </th>
//                     <th> First Name </th>
//                     <th> Last Name </th>
//                     <th> Precinct </th>
//                     <th>Phone Number</th>
//                     <th> Status </th>
//                 </tr>";

    
//     // will show everything if no fields are entered
//     $aQuery = " SELECT * FROM officer o ";
//     if($bNum !== "") {
//         $aQuery .= " WHERE o.badge_number = " . $bNum;
//     }
//     $aQuery .= ";";
//     // adds a row to the HTML for each row on the table
//     // NEED TO ADD A PAGE LIMIT FEATURE IN THE FUTURE
//     $result = $database->query($aQuery);
//     if($result->num_rows > 0) {
//         while($row = $result->fetch_assoc()) {
//             echo "<tr>";
//             echo "<th>" . $row["badge_number"] . "</th>";
//             echo "<th>" . $row["o_first"] . "</th>";
//             echo "<th>" . $row["o_last"] . "</th>";
//             echo "<th>" . $row["o_precinct"] . "</th>";
//             echo "<th>" . $row["o_phone_number"] . "</th>";
//             if($row["o_status"] === "a") {
//                 echo "<th>" . "Active" . "</th>";
//             }
//             else {
//                 echo "<th>" . "Inactive" . "</th>";
//             }  
//             echo "</tr>";
//         }
//     }
//     echo "</table>";
// }
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
