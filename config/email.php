<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    // 'smtp_host' => 'smtp.sahara-group.com',
    'smtp_port' => 465,
    // 'smtp_port' => 25,
    'smtp_user' => 'isaiahiroko@gmail.com',
    // 'smtp_user' => 'isaiah.iroko@sahara-group.com',
    'smtp_pass' => 'asdf;lkj',
    // 'smtp_pass' => '-081Dijudo02',
    'mailtype'  => 'html', 
    'charset'   => 'iso-8859-1' 
);

// $config['protocol'] = 'sendmail';
// $config['mailpath'] = '/usr/sbin/sendmail';
// $config['charset'] = 'iso-8859-1';
// $config['wordwrap'] = TRUE;

// Preference 	Default Value 	Options 	Description
// useragent 	CodeIgniter 	None 	The “user agent”.
// protocol 	mail 	mail, sendmail, or smtp 	The mail sending protocol.
// mailpath 	/usr/sbin/sendmail 	None 	The server path to Sendmail.
// smtp_host 	No Default 	None 	SMTP Server Address.
// smtp_user 	No Default 	None 	SMTP Username.
// smtp_pass 	No Default 	None 	SMTP Password.
// smtp_port 	25 	None 	SMTP Port.
// smtp_timeout 	5 	None 	SMTP Timeout (in seconds).
// smtp_keepalive 	FALSE 	TRUE or FALSE (boolean) 	Enable persistent SMTP connections.
// smtp_crypto 	No Default 	tls or ssl 	SMTP Encryption
// wordwrap 	TRUE 	TRUE or FALSE (boolean) 	Enable word-wrap.
// wrapchars 	76 	  	Character count to wrap at.
// mailtype 	text 	text or html 	Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don’t have any relative links or relative image paths otherwise they will not work.
// charset 	$config['charset'] 	  	Character set (utf-8, iso-8859-1, etc.).
// validate 	FALSE 	TRUE or FALSE (boolean) 	Whether to validate the email address.
// priority 	3 	1, 2, 3, 4, 5 	Email Priority. 1 = highest. 5 = lowest. 3 = normal.
// crlf 	\n 	“\r\n” or “\n” or “\r” 	Newline character. (Use “\r\n” to comply with RFC 822).
// newline 	\n 	“\r\n” or “\n” or “\r” 	Newline character. (Use “\r\n” to comply with RFC 822).
// bcc_batch_mode 	FALSE 	TRUE or FALSE (boolean) 	Enable BCC Batch Mode.
// bcc_batch_size 	200 	None 	Number of emails in each BCC batch.
// dsn 	FALSE 	TRUE or FALSE (boolean) 	Enable notify message from server