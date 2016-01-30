<?php 
session_start();
$text = urldecode($_GET["text"]);
//「twitteroauth.php」読み込み
//「OAuth.php」は「twitteroauth.php」と同じ場所に配置します
require_once "./oauth/twitterOAuth.php";
if(isset($_SESSION["LOGIN"])){
    // 「Consumer key」値
    $ck = "***";
    // 「Consumer secret」値
    $cs = "***";
    // Access Token
    $at = "***";
    // Access Token Secret
    $ats = "***";
    $sn = "******";
}else{
    $array = array("status"=>"false","code"=>777,"message"=>"Not Found Session");
    goto end;
}

//リクエストを投げる先（固定値）
$url = "https://api.twitter.com/1.1/statuses/update.json";
$method = "POST";

// OAuthオブジェクト生成
$toa = new TwitterOAuth($ck,$cs,$at,$ats);

$code = "";
$message = "";
//投稿
$res = $toa->OAuthRequest($url,$method,array("status"=>$text." #MusicPlayer_By_Tomachi"));

$ress = json_decode($res); 
$code = $ress->errors[0]->code;
$message = $ress->errors[0]->message;
if($code == ""){
     $array = array("status"=>"true");
     //echo $res;

}else{
     $array = array("status"=>"false","code"=>$code,"message"=>$message);
}
end:
die(json_encode($array));
