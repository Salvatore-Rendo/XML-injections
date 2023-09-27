<?php
    // UNSAFE SERVER against XXE: PHP

    //ignore deprecated warnings for a better visibility during the tests
    error_reporting(E_ALL ^ E_DEPRECATED);

    //enable External Entities
    libxml_disable_entity_loader(false);

    //Creates a variable for the XML input
    $xmlfile = file_get_contents('php://input');
    $dom = new DOMDocument();
    try {
        //Dom loading
        $dom->loadXML($xmlfile,LIBXML_NOENT | LIBXML_DTDLOAD);
        $login = simplexml_import_dom($dom);

        //Saves unsanitized input XML in local variables
        $user = $login->user;
        $pass = $login->pass;
        $mail = $login->mail;

        //Xml file opening + check if all attributes were sent
        $file = 'unsafe-server.xml';
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
            echo "BAD REQUEST";
        }
        //Check if the document is a valid XML document
        $doc = new \DOMDocument();
        $doc->Load($file);
        if ($doc -> validate()) {
            echo "<br><br>The XML file 'unsafe-server.xml' is valid";
        } else {
            echo "«br><br>The XML file is NOT valid : ERROR";
        }
        // Exception Handling
    } catch (Exception $e) {
        console.log($e);
        echo "Cannot load XML input, try using validate input";
    }
?>