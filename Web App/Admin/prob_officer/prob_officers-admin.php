<?php 
    include "db-functions-admin.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="../CSS/main.css">
        <link rel="stylesheet" type="text/css" href="../CSS/table.css">
        <link rel="stylesheet" type="text/css" href="../CSS/search-form.css">

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
                    <a class="nav-item nav-link" href="">Admin</a>
                    <a class="nav-item nav-link" href="criminals-admin.php">Criminals</a>
                    <a class="nav-item nav-link" href="crimes-admin.php">Crimes</a>
                    <a class="nav-item nav-link" href="charges-admin.php">Charges</a>
                    <a class="nav-item nav-link" href="sentences-admin.php">Sentences</a>
                    <a class="nav-item nav-link" href="appeals-admin.php">Appeals</a>
                    <!-- <a class="nav-item nav-link" href="officers-admin.php">Officers</a> -->
                    <div class="dropdown">
                      <div  class="nav-item nav-link">
                        <a class ="dropbtn">Officers</a>
                      </div>
                      <div class="dropdown-content">
                        <a href="officers-admin.php">Officiers</a>
                        <a href="crime_officers-admin.php">Crime Officers</a> 
                        <a href="prob_officers-admin.php">Probation Officers</a> 
                        <!-- Logout should lead to non-admin homepage -->
                      </div>
                    </div>
                  </div>

                  
                  <!-- Right Side of Navigation Bar -->
                  <div class="navbar-nav">
                    <a href="">
                        <img tag="help" src="../../Images/help.png" alt="Help">
                    </a>

                    <!-- Dropdown menu on Profile Button -->
                    <div class="dropdown">
                      <a class ="dropbtn" href="">
                        <img tag="profile" src="../../Images/profile.png" alt="My Profile">
                      </a>

                      <div class="dropdown-content">
                        <a href="#">My Profile</a>
                        <a href="#">Log Out</a> 
                        <!-- Logout should lead to non-admin homepage -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </nav>
        </header>
        <center>
            <div style="width:1000px;">
                <div  class="edit-search" style ="margin: 10px auto; display:inline-block;">
                    <button style="width:150px; > <a style="color:inherit;font-size: inherit;line-height: inherit;" href="search-officers-admin.php">Search Table</a></button>
                </div>
                <div class="edit-search" style ="margin: 10px auto; display:inline-block;">
                    <button style="width:150px;"> <a style="color:inherit;font-size: inherit;line-height: inherit;" href="edit-officers-admin.php">Update Table</a></button>
                </div>
                <div class="edit-search" style ="margin: 10px auto; display:inline-block;">
                    <button style="width:150px;><a style="color:inherit;font-size: inherit;line-height: inherit;" href="add-officers-admin.php">Add Record</a></button>
                </div>
            </div>
        </center>

        <div style="margin: auto;" > 
            <?php 
                // When a field is submitted, it will run this code
                $db = connectToDB_admin();
                Show_officer($db);
             ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>