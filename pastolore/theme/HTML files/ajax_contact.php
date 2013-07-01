<?php

// e-mail address to which the message will be send
$email_to = 'youraddress@email.com';
$subject = 'My contact form';

if( !empty( $_POST['email'] ) && !empty( $_POST['message'] ) && !empty( $_POST['name'] ) )
{
  $subject = '=?UTF-8?B?' . base64_encode( $subject ) . '?=';
  $message = nl2br( $_POST['message'] );
  $headers = 'From: ' . $_POST['name'] . ' <' . $_POST['email'] . '>' . "\r\n" . 'Reply-To: ' . $_POST['name'] . ' <' . $_POST['email'] . '>' . "\r\nContent-Type: text/plain; charset=utf-8\r\n";

  mail( $email_to, $subject, $message, $headers );
}

?>