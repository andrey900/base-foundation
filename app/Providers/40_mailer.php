<?php

/*$transport = (new Swift_SmtpTransport('smtp.zoho.eu', 465, 'ssl'))
  ->setUsername('andrey_900@zoho.eu')
  ->setPassword("ubggjuhba");*/
//$transport = new Swift_SendmailTransport('/usr/sbin/sendmail -bs');

// $mailer = new Swift_Mailer($transport);	


$container['mailer'] = function ($container) {
	$transport = new Swift_NullTransport;
	return new Swift_Mailer($transport);	
};

/*$message = (new Swift_Message('Wonderful Subject'))
  ->setFrom(['ba_ndrey@bigmir.net' => 'Andrey Leo'])
  ->setTo(['ba_ndrey@bigmir.net'])
  ->setBody('Here is the message itself');

// Send the message
$result = $mailer->send($message);*/