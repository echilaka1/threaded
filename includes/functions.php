<?php 
// FUNCTIONS.php_ini_loaded_file

//clean the form data to prevent injections

/* Built in functions used:
   trim()
   stripslashes()
   htmnlspecialchars()
   strip_tags()
   str_replace()
*/

function validateFormData ($formData){
    $formData = trim(stripslashes(htmlspecialchars(strip_tags(str_replace(array(
        '(', ')' ), '', $formData )), ENT_QUOTES )));
    return $formData;
}


?>