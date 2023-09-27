<?php
    // SAFE SERVER against XXE: PHP

    //ignore deprecated warnings for a better visibility during the tests
    error_reporting(E_ALL ^ E_DEPRECATED);

    //Creates a variable for the XML input
    $xmlfile = file_get_contents('php://input');
    $dom = new DOMDocument();
    try {
        //Dom loading
        $dom->loadXML($xmlfile);
        $login = simplexml_import_dom($dom);

        //Saves sanitized input XML in local variables
        $user = filter_var($login->user, FILTER_SANITIZE_STRING);
        $pass = filter_var($login->pass, FILTER_SANITIZE_STRING);
        $mail = filter_var($login->mail, FILTER_SANITIZE_STRING);

        //Xml file opening + check if all attributes were sent
        $file = 'safe-server.xml';
        if (!empty($user) && !empty($pass) && !empty($mail)) {

            $xml = simplexml_load_file($file);

            //creates the new Xml object and appends it on file
            $userxml= $xml->addChild('login');
            $userxml->addChild('user', $user);
            $userxml->addChild('pass', $pass);
            $userxml->addChild('mail', $mail);

            //saves the edited file
            $xml->asXML($file);

            //prints login
            echo "You have logged in as user $user and mail $mail";

        } else {
            echo " BAD REQUEST";
        }
        //Check if the document is a valid XML document
        $doc = new \DOMDocument();
        $doc->Load($file);
        if ($doc -> validate()) {
            echo "<br><br>The XML file 'safe-server.xml' is valid";
        } else {
            echo "«br><br>The XML file is NOT valid : ERROR";
        }
        // Exception Handling
    } catch (Exception $e) {
        console.log($e);
        echo "Cannot load XML input, try using validate input";
    }
?>