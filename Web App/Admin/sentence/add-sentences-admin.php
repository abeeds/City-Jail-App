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
                    <a class="nav-item nav-link" href="sentences-admin.php">Sentences</a>
                    <a class="nav-item nav-link" href="../appeal/appeals-admin.php">Appeals</a>
                    <!-- <a class="nav-item nav-link" href="officers-admin.php">Officers</a> -->
                    <div class="dropdown">
                      <div  class="nav-item nav-link">
                        <a class ="dropbtn">Officers</a>
                      </div>
                      <div class="dropdown-content">
                        <a href="../officer/officers-admin.php">Officer</a>
                        <a href="../crime_officer/crime_officers-admin.php">Crime per Officer</a> 
                        <a href="../prob_officer/prob_officers-admin.php">Probation Officer</a> 
                        <!-- Logout should lead to non-admin homepage -->
                      </div>
                    </div>
                  </div>
                  
                  <!-- Right Side of Navigation Bar -->
                  <div class="navbar-nav">
                    <a href="../../User/criminals.php"><strong>Log Out</strong></a>
                  </div>
                </div>
              </div>
            </nav>
        </header>      
        <center>
          <div method="get" class="form">
              <div class="form-panel one">
                <div class="form-header">
                  <h1>Add Sentence</h1>
                </div>
                  <form>
                    <div class="form-group">
                          <label for="sid">Sentence ID</label>
                          <input id="sid" type="number" name="sid" min="0"/>
                      </div>
                    <div class="form-group">
                          <label for="cid">Criminal ID</label>
                          <input id="cid" type="number" name="cid" min="0"/>
                      </div>
                    <div class="form-group">
                      <label for="probid">Probation Officer ID</label>
                      <input id="probid" type="number" name="probid" min="0"/>
                    </div>
                    <div class="form-group">
                      <label for="start_date">Start Date</label>
                      <input id="start_date" type="date" name="start_date"/>
                    </div>
                    <div class="form-group">
                      <label for="end_date">End Date</label>
                      <input id="end_date" type="date" name="end_date"/>
                    </div>
                    <div class="form-group">
                          <label for="numVio">Number of Violations</label>
                          <input id="numVio" type="number" name="numVio" min="0"/>
                      </div>
                    <div class="form-group">
                      <label for="type">Sentence Type</label>
                      <select name="type" id="type">
                        <option value=""></option>
                        <option value="p">Probation</option>
                        <option value="h">House Arrest</option>
                        <option value="j">Jail</option>
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
                add_sentence($_GET["sid"], $_GET["cid"],$_GET["probid"], $_GET["start_date"], $_GET["end_date"], $_GET["numVio"], $_GET["type"], $db);
              }
            ?>
        </center>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>