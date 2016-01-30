<?php
session_start();
if(!isset($_SESSION["LOGIN"])){die("<a href=\"login.php\">Please Login!</a>");}
require_once("getid3.php");
$getID3 = new getID3();
$dir = "./data/";
$files = array();
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if($file != "." && $file != ".." && $file != ".htaccess"){
              $str = urldecode($file);
$to_encoding = 'UTF-8';
$from_encoding = null;
foreach(array("UTF-8",'SJIS','EUC-JP','ASCII','JIS') as $charcode){
	if(mb_convert_encoding($str, $charcode, $charcode) == $str){
		$from_encoding = $charcode;
		break;
	}
}
if(!$from_encoding){
	echo 'ERROR: 文字コードが判別出来ませんでした。';
	exit;
}
if($to_encoding == $from_encoding){
	$file = $str;
	goto a;
}

$file = mb_convert_encoding($str, $to_encoding, $from_encoding);
a:
$getID3->setOption(array('encoding' => 'UTF-8'));
$filename = mb_convert_encoding($file, "SJIS", "auto");
$fileInfo = $getID3->analyze("./data/".$filename);
getid3_lib::CopyTagsToComments($fileInfo);

              $files[] = $fileInfo["comments"]["artist"][0]."###".$fileInfo["comments"]["album"][0]."###".$file."###".$fileInfo['playtime_string'];
            }
        }
        closedir($dh);
    }
}
asort($files);
reset($files);
?><html>
<head>
<title>Music</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<script src="script.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body onload="pageload();" class="wp-admin">
<p>Music:<span id="musicname"></span><br>Now:<span id="ended"></span><br>
<span id="current"></span><span id="su"></span><span id="duration"></span><br>
<button onclick="musicstart();" id="play">再生</button> <button onclick="musicpause();">停止</button></p>
<table border="1">
<?php
foreach($files as $file){
$file = explode("###",$file);
$filename = mb_convert_encoding($file[2], "SJIS", "auto");
$f = str_replace("%21", "!",str_replace("+", " ",urlencode($filename)));
echo"<tr><td id=\"artist\">".$file[0]."</td><td id=\"album\">".$file[1]."</td><td id=\"file\">".$file[2]."</td><td id=\"time\">".$file[3]."</td><td id=\"button\"><button onclick=\"musicstart('".str_replace("'","\'",$file[2])."','".str_replace("'","\'",$f)."','".str_replace("'","\'",$file[0])."','".str_replace("'","\'",$file[1])."');\">聴く</button></td></tr>\n";
}
?>
</table>
<audio src="" id="music" controls autoplay></audio>
<button id="load"></button>
</body>
</html>
