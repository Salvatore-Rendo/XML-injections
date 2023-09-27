
<!-- LOGINS.PHP -->

<?php

    //ignore deprecated warnings for a better visibility
    // during the tests
    error_reporting(E_ALL ^ E_DEPRECATED);

    //checks if user mail and pass exists.
    if (isset($_POST) && isset($_POST['user'])
        && isset($_POST['mail']) && isset($_POST['pass'])){
        //Saves sanitized input XML in local variables
        $user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
        $mail = filter_var($_POST['mail'], FILTER_SANITIZE_STRING);
        $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
        // opens logins and stores the recived sanitized data
        $file = 'login.xml';
        if ($file) {
            $xml = simplexml_load_file($file);
            $userxml = $xml->addChild('login');
            $userxml->addChild('user', $user);
            $userxml->addChild('pass', $pass);
            $userxml->addChild('mail', $mail);

            //saves the edited file
            $xml->asXML($file);

            //prints login
            echo "<br>You have logged in as user $user and mail $mail<br>"  ;
        }
    } else {
        echo " Fill Form Correctly";
    }
?>
<html>

    <head>
        <title>HTML data: Storing in XML</title>
    </head>

    <body>
        <!-- Our page HTML form -->
        <form action="" method="post">
            User: <input type="text" name="user" id="">
            <br><br>
            pass: <input type="text" name="pass" id="">
            <br><br>
            mail: <input type="text" name="mail" id="">
            <br>
            <input type="submit" value="Submit">
        </form>
    </body>

</html>

<?php



    //Check if the document is a valid XML document
    $file = 'login.xml';
    $doc = new \DOMDocument();
    $doc->Load($file);
    if($doc -> validate()) {
        echo "<br><br>The XML file is valid";
    }else{
        echo "«br><br>The XML file is NOT valid : ERROR";
    }
?>