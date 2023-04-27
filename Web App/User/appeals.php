<?php 
  // This file holds the functions used
  include "db-functions.php"
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

        



        <title>City Jail</title>
    </head>
    <body> 
        <header class="site-header">
            <nav class="navbar navbar-expand-md navbar-dark navigBG fixed-top">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="container">
                <!-- Should lead to whatever the homepage is-->
                <a class="navbar-brand mr-4" href="criminals.php"><strong>City Jail</strong></a>
                </button>
                <!-- Navbar Toggler -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Main Navigation Pages -->
                <div class="collapse navbar-collapse" id="navbarToggle">
                  <div class="navbar-nav mr-auto">
                    <a class="nav-item nav-link" href="criminals.php">Criminals</a>
                    <a class="nav-item nav-link" href="crimes.php">Crimes</a>
                    <a class="nav-item nav-link" href="">Charges</a>
                    <a class="nav-item nav-link" href="sentences.php">Sentences</a>
                    <a class="nav-item nav-link" href="appeals.php">Appeals</a>
                  </div>
                  
                  <!-- Right Side of Navigation Bar -->
                  <div class="navbar-nav">
                    <a href="">
                        <img tag="help" src="../../Images/help.png" alt="Help">
                    </a>
                    
                    
                    <a href="login.php">
                      <img tag="profile" src="../../Images/profile.png" alt="Log In">
                    </a>

                  </div>
                </div>
              </div>
            </nav>

          </header>
        
          <center>
          <div method="get" class="form">
              <div class="form-panel one">
                <div class="form-header">
                  <h1>Appeal Search</h1>
                </div>
                  <form>
                    
                    <div class="form-group">
                      <label for="case_id">Case ID</label>
                      <input id="case_id" type="number" name="case_id" maxlength="5"/>
                    </div>
                    <div class="form-group">
                      <label for="filing_date">Filing Date</label>
                      <input id="filing_date" type="date" name="filing_date"/>
                    </div>
                    <div class="form-group">
                      <label for="appeal_hearing_date">State</label>
                      <input id="appeal_hearing_date" type="date" name="appeal_hearing_date"/>
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
                $db = connectToDB_guest();
              makeTable_criminal($_GET["name"], $_GET["case_id"], $_GET["filing_date"], $_GET["appeal_hearing_date"], $db);
              }
            ?>
        </center>
        
        
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
