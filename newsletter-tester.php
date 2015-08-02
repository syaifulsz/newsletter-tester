<?php

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'vendor/autoload.php';
require 'phpmailer/PHPMailerAutoload.php';

use PHPHtmlParser\Dom;

$output = null;
$formData = $_GET;
$email = (@$_GET['email'] ? $_GET['email'] : null);
$password = (@$_GET['password'] ? $_GET['password'] : null);
$send_to = (@$_GET['send_to'] ? $_GET['send_to'] : null);
$content = (@$_GET['nt_index'] ? $_GET['nt_index'] : null);

function slugify($string)
{
    $slug = preg_replace('/[\s]+/', '-', $string);
    $slug = str_replace('[-]+', '-', $slug);
    $slug = preg_replace('/[^\da-z-]/i', '', $slug);
    $slug = strtolower($slug);
    $slug = trim($slug, '-');

    return $slug;
}

if (@$email && @$password && $content) {

    // Create a new PHPMailer instance
    $mail = new PHPMailer;

    // Tell PHPMailer to use SMTP
    $mail->isSMTP();

    // Enable SMTP debugging
    $mail->SMTPDebug = 0;

    // Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

    // Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6

    // Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;

    // Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

    // Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    // Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $email;

    // Password to use for SMTP authentication
    $mail->Password = $password;

    //Set who the message is to be sent from
    $mail->setFrom($email, 'Newsletter Tester');

    //Set an alternative reply-to address
    $mail->addReplyTo($email, 'Newsletter Tester');

    // Set who the message is to be sent to
    $mail->addAddress($email);

    if (@$send_to && is_array($send_to)) {

        foreach ($send_to as $address) {
            $mail->addAddress($address);
        }
    }

    // Set the subject line
    $mail->Subject = 'Newsletter Tester [' . md5(time()) . ']';

    // Read an HTML message body from an external file, convert referenced images to embedded,
    // convert HTML into a basic plain-text alternative body

    if (@$content) {

        $content = file_get_contents('newsletters/' . $content);

        $dom = new Dom;

        $dom->load($content);

        $images = $dom->find('img');

        foreach ($images as $image) {

            $imageSrc = $image->getAttribute('src');

            $mail->AddEmbeddedImage('newsletters/' . $imageSrc, slugify($imageSrc));
            $content = str_replace($imageSrc, 'cid:' . slugify($imageSrc), $content);
        }

        $mail->msgHTML($content, dirname(__FILE__));
    }

    // Replace the plain text body with one created manually
    $mail->AltBody = 'Test with Newsletter Tester tool by Syaiful Shah Zinan';

    // send the message, check for errors
    if (!$mail->send()) {

        $output['status'] = 'error';
        $output['message'] = $mail->ErrorInfo;

    } else {

        $output['status'] = 'success';

    }
} else {

    $output['status'] = 'error';
    $output['message'] = 'Please specify E-mail and Password';

}

header('Content-Type: application/json');
echo json_encode($output);