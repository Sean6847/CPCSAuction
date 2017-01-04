<?
// Inspired by tutorials: http://www.phpfreaks.com/tutorials/130/6.php
// http://www.vbulletin.com/forum/archive/index.php/t-113143.html
// http://hudzilla.org


// Create the mysql backup file
// edit this section
$dbhost = "CPAuctionStore.db.9520494.hostedresource.com"; // usually localhost
$dbuser = "CPAuctionStore";
$dbpass = "Auct!0n123";
$dbname = "CPAuctionStore";
$sendto = "Sue Muir <CPCSAuction@laseritnow.com>";
$sendfrom = "Auction Backup <AuctionBackup@laseritnow.com>";
$sendsubject = "Daily Mysql Backup";
$bodyofemail = "Here is the daily backup.";
// don't need to edit below this section

$backupfile = $dbname . date("Y-m-d") . '.sql';
system("mysqldump -h $dbhost -u $dbuser -p$dbpass $dbname > $backupfile");

// Mail the file

include('Mail.php');
include('Mail/mime.php');

$message = new Mail_mime();
$text = "$bodyofemail";
$message->setTXTBody($text);
$message->AddAttachment($backupfile);
$body = $message->get();
$extraheaders = array("From"=>"$sendfrom", "Subject"=>"$sendsubject");
$headers = $message->headers($extraheaders);
$mail = Mail::factory("mail");
$mail->send("$sendto", $headers, $body);


// Delete the file from your server
unlink($backupfile);
?>
