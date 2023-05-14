<h1>City-Jail-App</h1>
  <p>
    City Jail App is a web application that allows users to access a MYSQL database. This app features a public view that allows users to search criminal and crime related data. There is also an admin view, accessed through the login, that allows for more detailed searches, inserting new data entries, updating existing entries, and deleting existing entries. We did host this app on AWS shortly, but we have taken it down.
  </p>
  <p> 
    This app was written using the following languages<br>
    <a href="https://skillicons.dev">
    <img src="https://skillicons.dev/icons?i=php,html,css,mysql" alt="php, html, css, mysql"/>
    </a>
  </p>
  
  <h2>General Documentation</h2>
  <p>
    Each of the individual webpages are stored in the User or Admin folders. Both folders rely on the CSS that is in the CSS folder. Within each folder there are files named 'db-functions.php' and 'db-functions-admin.php'. Inside these files are all database calls and queries that are being run based on the fields entered in each page. In 'db-functions-admin.php', there are only 4 different types of functions: search, insert, update, and delete.
  </p>

  
 <h2>Previews</h2>
  <a>
    <img src="https://i.imgur.com/34quePz.png"/>
    <img src="https://i.imgur.com/c3kKOC8.png"/>
    <img src="https://i.imgur.com/m3ZYHsK.png"/>
    <img src="https://i.imgur.com/cM8HYFX.png"/>
    <img src="https://i.imgur.com/17nFgJG.png"/>
    <img src="https://i.imgur.com/hYbykwm.png"/>
    <img src="https://i.imgur.com/662ownY.png"/>
  </a>

<h2>Entity Relationship Diagram</h2>

![Entity Relationship Diagram](https://user-images.githubusercontent.com/84909990/230780979-7adecf93-a58a-4179-9342-caf466d2635a.jpg)

<h2>Schema Statements</h2>
criminal(c_id, c_last, c_first, c_street, c_city, c_state, c_zip, c_phone_num, V_status, P_status) <br /> 
alias(alias_id, @c_id, alias) <br /> 
crime(case_id, @c_id, classification, date_charged, appeal_status, appeal_cutoff_date) <br /> 
prof_officer(p_id, p_last, p_first, p_street, p_city, p_state, p_zip, p_email, p_status) <br /> 
sentence(sentence_id, @c_id, @p_id, start_date, end_date, num_violations, type) <br /> 
officer(badge_number, o_last, o_first, o_precinct, o_phone_number, o_status) <br /> 
crime_officer(@badge_number, @case_id) <br /> 
crime_code(code_num, code_desc) <br /> 
charge(charge_id, @case_id, @code_num, charge_status, fine_amount, court_fee, amount_paid, payement_date) <br /> 
appeal(attempt_num, @case_id, filling_date, appeal_hearing_date, result_status) <br />
