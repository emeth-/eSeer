<?
require_once('inc.php');

$id = mysql_real_escape_string($_GET['id']);

$a = mysql_query("SELECT * FROM pending WHERE id='$id'");
if (mysql_num_rows($a))
{
    $b = mysql_fetch_array($a);
    
    $ext = strtolower(end(explode('.', $b['imageurl'])));
    
    if ($ext == 'jpg')
    {
        $im = imagecreatefromjpeg($b['imageurl']);
        header('Content-Type: image/jpeg');
        imagejpeg($im);
    }
    elseif ($ext == 'png')
    {
        $im = imagecreatefrompng($b['imageurl']);
        header('Content-Type: image/png');
        imagepng($im);
    }
    elseif ($ext == 'gif')
    {
        $im = imagecreatefromgif($b['imageurl']);
        header('Content-Type: image/gif');
        imagegif($im);
    }
    elseif ($ext == 'bmp')
    {
        $im = imagecreatefromwbmp($b['imageurl']);
        header('Content-Type: image/bmp');
        imagebmp($im);
    }
    else
    {
        $im = imagecreatefrompng($b['imageurl']);
        header('Content-Type: image/png');
        imagepng($im);
    }
    
    imagedestroy($im);

    $message = $b['message']."\n\n-----------\n\nUser Information:\n";
    $message .= "IP: ".$_SERVER['REMOTE_ADDR']."\n";
    $message .= "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\n";
    $message .= "Refer: ".$_SERVER['HTTP_REFERER']."\n\n";
    $message .= "Time Opened: ".date('Y-m-d H:i:s', time())."\n";
    $message .= "Notification Setup: ".date('Y-m-d H:i:s', $b['time'])."\n";
    $message .= "Time between Setup and Open: ".time_diff_conv(time(), $b['time'])."\n";
    
    $to      = $b['email'];
    $subject = 'Notification Activated - eSeer';
    $headers = 'From: '.$b['email']."\r\n";
    $headers .= "Content-type: text/html\r\n";
    mail($to, $subject, nl2br($message), $headers);
    mysql_query("DELETE FROM pending WHERE id='$id'");
}

function time_diff_conv($start, $s) {
    $t = array( //suffixes
        'd' => 86400,
        'h' => 3600,
        'm' => 60,
    );
    $s = abs($s - $start);
    foreach($t as $key => &$val) {
        $$key = floor($s/$val);
        $s -= ($$key*$val);
        $string .= ($$key==0) ? '' : $$key . "$key ";
    }
    return $string . $s. 's';
}

?>

