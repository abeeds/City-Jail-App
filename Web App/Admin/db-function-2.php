<?php
    include "db-functions-admin.php";

function delete_charge($chargeid, $database=NULL) {
        if(!$database) {
            echo "<p> Failed to connect to database. </p>";
            return;
        }
    
        
        if($chargeid !== "") {
            $aQuery = " DELETE FROM charge ";
            $aQuery .= " WHERE charge_id = " . $chargeid;
            $aQuery .= " ; ";
            if (mysqli_query($database, $aQuery)) {
                //$rows = mysqli_affected_rows($database);
                echo "<p> Delete successful.</p>";
            } else {
                //echo "Error: " . mysqli_error($database);
                echo "<p>Error: </p>";
            }
        }
    }

    // This function will add Probation officers
function add_charge($chargeid, $caseid, $codenum, $chargeStat ,$fine, $court, $paid, $paymentdate,  $database=NULL) {
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

    $aQuery = "INSERT INTO charge ";
    $aQuery .= " (charge_id, case_id, code_num, charge_status, fine_amount, court_fee, amount_paid, payment_date)";
    $aQuery .= " VALUES";

    // INSERT INTO charge
    // (charge_id, case_id, code_num, charge_status, 
    // fine_amount, court_fee, amount_paid, payment_date)
    // VALUES
    // (2142, 1, 3298,-"p", 500, 250, 0, '1990-10-15'),

    $aQuery .= " (${chargeid}, ${caseid}, ${codenum}, \"${chargeStat}\", ${fine}, ${court}, ${paid}, '${paymentdate}');";
    // echo "<p>$aQuery</p>";
    if (mysqli_query($database, $aQuery)) {
        //$rows = mysqli_affected_rows($database);
        echo "<p> Insert successful.</p>";
    } else {
        //echo "Error: " . mysqli_error($database);
        echo "<p>Error: </p>";
    }
}

