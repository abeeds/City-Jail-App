<?php 
    include "../db-functions-admin.php";
    if (!isset($_COOKIE['username'])) {
      header('Location: ../../User/criminals.php');
      exit;
  }
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="../../CSS/main.css">
        <link rel="stylesheet" type="text/css" href="../../CSS/table.css">
        <link rel="stylesheet" type="text/css" href="../../CSS/search-form.css">

        <title>City Jail - admin</title>
    </head>
    <body> 

        <header class="site-header">
            <nav class="navbar navbar-expand-md navbar-dark navigBG fixed-top">
              <div class="container">
                <!-- Should lead to whatever the homepage is-->
                <a class="navbar-brand mr-4" href=""><strong>City Jail</strong></a> 
                </button>
                <!-- Navbar Toggler -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Main Navigation Pages -->
                <div class="collapse navbar-collapse" id="navbarToggle">
                <div class="navbar-nav mr-auto">
                    <a class="nav-item nav-link" href="../criminal/criminals-admin.php">Criminals</a>
                    <a class="nav-item nav-link" href="../crime/crimes-admin.php">Crimes</a>
                    <a class="nav-item nav-link" href="../charge/charges-admin.php">Charges</a>
                    <a class="nav-item nav-link" href="../sentence/sentences-admin.php">Sentences</a>
                    <a class="nav-item nav-link" href="../appeal/appeals-admin.php">Appeals</a>
                    <!-- <a class="nav-item nav-link" href="officers-admin.php">Officers</a> -->
                    <div class="dropdown">
                      <div  class="nav-item nav-link">
                        <a class ="dropbtn">Officers</a>
                      </div>
                      <div class="dropdown-content">
                        <a href="../officer/officers-admin.php">Officer</a>
                        <a href="../crime_officer/crime_officers-admin.php">Crime per Officer</a> 
                        <a href="prob_officers-admin.php">Probation Officer</a> 
                      </div>
                    </div>
                  </div>
                  
                  <!-- Right Side of Navigation Bar -->
                  <div class="navbar-nav">
                  <a href="../logout.php"><strong>Log Out</strong></a>
                  </div>
                </div>
              </div>
            </nav>
        </header>      
        <center>
                    
            <div method="get" class="form">
                    
                <div class="form-panel one">
                    <div class="form-header">
                    <h1>Update Probation Officer's Details</h1>
                    </div>
                    <form>
                                <div class="form-group">
                                    <label for="pid">Update Probation Officer with Id</label>
                                    <input id="pid" type="number" name="pid" min="0" max="999999999" required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="fname">First Name</label>
                                    <input id="fname" type="text" name="fname" maxlength="41"/>
                                </div>
                                <div class="form-group">
                                    <label for="lname">Last Name</label>
                                    <input id="lname" type="text" name="lname" maxlength="41"/>
                                </div>
                                <div class="form-group">
                                    <label for="phonenum">Phone Number</label>
                                    <input id="phonenum" type="number" name="phonenum" min="1" max="9999999999"/>
                                </div>
                                <div class="form-group">
                                    <label for="street">Street</label>
                                    <input id="street" type="text" name="street" maxlength="64"/>
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input id="city" type="text" name="city" maxlength="64"/>
                                </div>
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input id="state" type="text" name="state" maxlength="2"/>
                                </div>
                                <div class="form-group">
                                    <label for="zip">Zip Code</label>
                                    <input type="number" id="zip" name="zip" min="1" max="99999">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email">
                                </div>
                                <div class="form-group">
                                  <label for="status">Status</label>
                                  <select name="status" id="status">
                                    <option value=""></option>
                                    <option value="a">Active</option>
                                    <option value="i">Inactive</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit">Submit</button>
                                </div>
                            </form>
                </div>
            </div>
            <?php 
                // When a field is submitted, it will run this code
                if($_GET){
                  $db = connectToDB_admin();
                  update_prob_officer($_GET["pid"], $_GET["lname"], $_GET["fname"], $_GET["street"] ,$_GET["city"], $_GET["state"], $_GET["zip"], $_GET["phonenum"],$_GET["email"],$_GET["status"], $db);
                }
            ?>
            
        </center>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>