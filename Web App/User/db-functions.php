<?php
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
    // making upper most row with labels
    echo 
    "<table id=\"Criminals\">
    <!-- Row with labels for each column -->
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

    // only form query if connected to database
    if($database !== NULL) {
        $aQuery = "SELECT * FROM criminal c";
        

        // add WHERE clause as long as one field is present
        if($name !== "" || $city !== "" || $state !== "" || $zip !== "") {
            $aQuery .= " WHERE ";
            $aQuery .= "CONCAT(c.c_first, c.c_last) LIKE '%" . $name . "%' AND ";
            $aQuery .= "c.c_city LIKE '%" . $city . "%' " ;
            if($city !== "") {
                $aQuery .= "OR c.c_city = '" . $city . "'" ;
            }
            
            $aQuery .= " AND c.c_state LIKE '%" . $state . "%'" ;
            if($state !== "") {
                $aQuery .= " OR c.c_state = '" . $state . "'" ;
            }
            
            if($zip !== "") {
                $aQuery .= " AND c.c_zip = " . $zip . ";";
            }
        }

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

    }
  echo "</table>";
}
?>