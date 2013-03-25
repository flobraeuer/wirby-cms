<?php
  date_default_timezone_set('Europe/Vienna');
  header('Content-type: application/json; charset=utf-8');

  error_reporting(/*E_ALL*/E_STRICT);
  //ini_set('display_errors', TRUE);
  
  /**
   ** Tracking
   **/
  
  function track($note=""){
    $type = "mail";
    $date = date("Y-m-d H:i:s");
    $user = isset($_SESSION["user"]) ? $_SESSION["user"][2] : 0;
    $addr = $_SERVER["REMOTE_ADDR"];
    $client = $_SERVER["HTTP_USER_AGENT"];
    try{
      DB::insert("logs", array( "type" => $type, "user" => $user, "date" => $date, "ip" => $addr, "client" => $client, "note" => $note ) );
    }catch(Exception $e){ return false; }
    return true;
  };
  
  // Database
  require_once "meekrodb/meekrodb.1.6.class.php";
  DB::$user = "cust_knotzer";
  DB::$dbName = "cust_knotzer";
  DB::$password = "knotzer_geheim";
  DB::$encoding = "utf8";
  
  /**
   ** Email
   **/
  
  $email = $_POST["email"];
  
  if( isset($email) ){
    if( strlen($email["name"])>2 && strlen($email["address"])>5 && strlen($email["message"])>15 ){
      if( preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,6}$/', $email["address"]) ){
      
        try {
          require_once('mailer/class.phpmailer.php');
          $mail = new PHPMailer();
        
          $email["to"] = "mknotzer@me.com";
          $email["body"] = "
            <html>
            <head> <title>Homepage Kontaktaufnahme</title> </head>
            <body>
              <p>Hallo Michael.</p>
              <p>Diese Nachricht wurde über das Kontaktformular<br />
              der Homepage verschickt:</p>
              <table width='500px'>
                <tr><td width='100px'><b>Name</b></td><td>" . $email["name"] . "</td></tr>
                <tr><td><b>Email</b></td><td><a href='mailto:" . $email["address"] . "'>" . $email["address"] . "</a></td></tr>
                <tr><td><b>Nachricht</b></td><td>" . $email["message"] . "</td></tr>
              </table>
              <br /><a href='mailto:" . $email["address"] . "'><b>Antworten</b></a>
            </body>
            </html>
          ";
        
          $mail->AddAddress($email["to"], "Michael");
          $mail->SetFrom("hallo@webarchitects.at", "web architects");
          $mail->AddReplyTo($email["address"], $email["name"]);

          $mail->Subject = "Homepage Kontaktaufnahme";
          $mail->AltBody = $email["message"];
          $mail->CharSet = "utf-8";
          $mail->MsgHTML( $email["body"] );

          $mail->IsSMTP();                // telling the class to use SMTP
          $mail->SMTPDebug = 1;           // enables SMTP debug information (1 = errors and messages, 2 = messages only)
          $mail->SMTPAuth  = true;                          // enable SMTP authentication
          $mail->Host      = "wp239.webpack.hosteurope.de"; // SMTP server
          $mail->Username  = "wp10566993-webarchitects";    // SMTP account username
          $mail->Password  = "tqh6t3z38j";                  // SMTP account password

          $send = $mail->Send();
          track($email["address"].": ".substr($email["message"],0,200)." ...");
      
          $output = array(
            "status" => ($send ? "success" : "error"),
            "from" => $email["address"],
            "to" => $email["to"],
            "msg" => $email["body"]
          );
        
        } catch (Exception $e) { json_encode( array("status" => "error", "error" => ($e->getMessage()) ) ); };
      } else $output = array( "status" => "error", "error" => "Email nicht gültig" );
    } else $output = array( "status" => "error", "error" => "Bitte alles ausfüllen" );
  } else $output = array( "status" => "error", "error" => "Bitte über das Formular verschicken" );
  
  echo json_encode($output);
  
  /* Standard Mail
  $email["to"] = "florian@webarchitects.at";
  $email["from"] = "knotzer@webarchitects.at";
  $email["subject"] = "Homepage-Kontakt";
  $email["header"] =
    "To: " . $email["to"] . "\r\n" .
    "From: " . $email["from"] . "\r\n" .
    "Reply-To: " . $email["address"] . "\r\n" .
    "X-Mailer: PHP/" . phpversion() .
    "MIME-Version: 1.0" . "\r\n" .
    "Content-type: text/html; charset=iso-8859-1" . "\r\n";
  $send = mail($email["to"], $email["subject"], $email["body"], $email["header"]);
  */
?>