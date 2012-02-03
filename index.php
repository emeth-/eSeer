<?
require_once('inc.php');

$url = mysql_real_escape_string($_POST['imageurl']);
$email = mysql_real_escape_string($_POST['email']);
$message = mysql_real_escape_string($_POST['message']);

if(!$url){$url='transparent.png';}
if($email && $message && $url)
{
    $time = time();
    $id = md5($email.$message.$time.$imageurl);
    mysql_query("INSERT INTO pending (id, email, message, time, imageurl)
                    VALUES('$id', '$email', '$message', $time, '$url')");
    
    $ext = strtolower(end(explode('.', $url)));
    $imgurlhtaccess = pageurl().$id.".".$ext;
    $imgurlreg = pageurl()."image.php?id=".$id;
    print "Notification service created. Embed the following image in an email (or other html processing app) to be notified when your message is viewed.<br /><br />With .htaccess: <input type='text' value='".$imgurlhtaccess."'><br />Regular: <input type='text' value='".$imgurlreg."'><br /><br /><hr />";
}


function pageurl() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

?>

<form method='post' action=''>
    Image URL (leave blank for 1x1 transparent): <input type='text' name='imageurl'><br />
    Email to notify when package opened: <input type='text' name='email'><br />
    Notification Message (Use to identify what the notification was for)<br />
    <textarea name='message'></textarea><br />
    <input type='submit' value='Create'>
</form>

