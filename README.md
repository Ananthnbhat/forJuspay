# forJuspay
Project details:

*Done using localhost(xampp).
*Import the tbl_users(1).sql if needed.
*Details of database is in db_config.php

 Signup/login page:(signup.php/index.php)
 *Validation for all fields.
 *Cookies enabled.
 *User can either signup as a teacher or a student.
 *Records and updates the location of the user during each signup and login(real-time location).

Local map screen:(home.php)
 *Shows the google maps with different markes
 *If the user is a student then the map shows only the teachers within 1km radius(using getDistance function which returns the locations which are within 1km radius).
 *User can logout and return to signup/login page.
 *The locations of teachers(assuming user is astudent) are hard coded.This can be made dynamic by removing the comments in 'section   1'.

 

