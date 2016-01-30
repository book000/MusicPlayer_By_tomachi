/* global nowplay,musicname,s,e,encfile,audio,$ */
nowplay = false;
musicname = null;
s = null;
e = null;
encfile = null;
function pageload(){
  audio = document.getElementById("music");
}
function musicstart(s,e,artist,album){
  if(nowplay){
    alert("再生中だよー？");
    return;
  }
  if(s == null && musicname != null){
    audio.play();
    return;
  }else if(s == null && musicname == null){
    alert("曲が指定されてないです");
    return;
  }
  
  musicname = s;
  document.getElementById("musicname").innerHTML = musicname;
 audio.src="./data/"+e+"";
  audio.load();
  audio.autoplay = true;
audio.addEventListener("canplay", function() {
  //alert("canplay!");
    audio.play();
    tweet("Playingなう♪ " + s + "(" + artist + "/" + album + ")");
    }, false);

}
function musicstop(){
  nowplay = false;
  musicname = null;
  audio.currentTime = 0;
  audio.pause();
  audio.src = null;
  document.getElementById("current").innerHTML = "";
  document.getElementById("su").innerHTML = "";
  document.getElementById("duration").innerHTML = "";
  document.getElementById("musicname").innerHTML = "";
}
function musicpause(){
  audio.pause();
  nowplay = false;
}
function music(){
  if(!audio.paused){
    document.getElementById("ended").innerHTML = "再生中";
    nowplay = true;
  }else{
    document.getElementById("ended").innerHTML = "(一時)停止中";
    nowplay = false;
  }
  if(nowplay){
      document.title = "[再生中] " + musicname;
      var current = audio.currentTime;
      var current_k = Math.floor(current/60);
      var current_a = Math.floor(current%60);
      document.getElementById("current").innerHTML = current_k+":"+current_a;
      
      var duration = audio.duration;
      var duration_k = Math.floor(duration/60);
      var duration_a = Math.floor(duration%60);
      document.getElementById("duration").innerHTML = duration_k+":"+duration_a;
      document.getElementById("su").innerHTML = "/";
      //if(document.getElementById("current").innerHTML != "" && document.getElementById("current").innerHTML == document.getElementById("duration").innerHTML){musicstop();}
  }else if(!musicname){
    document.title = "[停止中]";
  }else{
    document.title = "[一時停止中] " + musicname;
  }
}
function tweet(text){
//var text = document.getElementById("tweet").value;
$.getJSON("http://localhost/tweet.php?text="+ encodeURI(text) ,function(json){
  if(json.status == "true"){
  //alert("success");
  document.getElementById("tweet").value = "";
  return false;
  }else{
  alert("Error\n" + json.code + "\n" + json.message);
  }
  });
}
setInterval("music();",1000);
