$(document).ready(function(){
  $.getJSON("/twitter", function(data){
  	for(i in data){
  	  var url = data[i];
  	  var div = "<blockquote class='twitter-tweet'><p>"
  	  		+data[i]['text']
  	  		+"</p>&mdash; "+data[i]['name']+"(@"+data[i]['screen_name']+")<a href='https://twitter.com/"+data[i]['screen_name']+"/status/"+data[i]['id']+"'</a></blockquote>"
  	  		+"<script src='//platform.twitter.com/widgets.js' charset='utf-8'></script>";
  	  $('#twitter').append(div);
  	}
  })
});