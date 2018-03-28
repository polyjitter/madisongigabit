<?php
if (isset($_POST['email'])) {

    $email_to = "registration@madisongigabit.com";
    $email_subject = "New Registration";

    // Error Handling
    function died($error)
    {
        // your error code can go here
        http_response_code(500);
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error . "<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }

    // Validating Data
    if (!isset($_POST['first_name']) ||
        !isset($_POST['last_name']) ||
        !isset($_POST['street']) ||
        !isset($_POST['town']) ||
        !isset($_POST['state']) ||
        !isset($_POST['zip']) ||
        !isset($_POST['telephone']) ||
        !isset($_POST['email'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $_POST['email'])) {
        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $_POST['first_name'])) {
        $error_message .= 'The First Name you entered does not appear to be valid.<br />';
    }

    if (!preg_match($string_exp, $_POST['last_name'])) {
        $error_message .= 'The Last Name you entered does not appear to be valid.<br />';
    }

    if (strlen($error_message) > 0) {
        died($error_message);
    }

    // Creates the XML
    $request_xml = new SimpleXMLElement("<registration/>");

    array_walk_recursive(
        array_flip($_POST),
        array($request_xml, 'addChild'));

    $email_message = $request_xml->asXML();

    // Emails the Registration
    $headers = 'From: ' . $email_from . "\r\n" .
    'Reply-To: ' . $email_from . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email_to, $email_subject, $email_message, $headers);
    ?>

Thank you for contacting us. We will be in touch with you very soon.

<?php

}
?>
