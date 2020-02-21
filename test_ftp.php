<?php

/**
 * Required Files
 */

// Main WIGUM Include
require($_SERVER['DOCUMENT_ROOT'] . "/library/core.php");

Wigum\Core\Load::module('ftp');

$host = '74.208.103.124';
$user = 'exposed';
$pass = '3xpu1n';
$port = 21;

$ftp = New FTP();

$ftp->print_log = true;

$ftp->set_host($host);
$ftp->set_port($port);
$ftp->set_pass($pass);
$ftp->set_user($user);

$ftp->connect();
$ftp->login();

$current_dir = $ftp->get_current_dir();

#$ftp->change_dir('/var/www/vhosts/exposeduniverse.com/wigum/');
$ftp->change_dir('bizulu/httpdocs/');

$dir_files = $ftp->get_dir_files();
#$ftp->get_file_details();

$ftp->download_file('/var/www/vhosts/exposeduniverse.com/wigum/httpdocs/cu3er.swf', 'cu3er.swf');

$ftp->disconnect();

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title><?php echo $page_title; ?></title>
    <link href="/css/calendar.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php
print_r($dir_files);
//echo $log_message;
?>

</body>
</html>