$(document).ready(function(){
  $.getJSON("/google", function(data){
  	for(i in data){
  	  var url = data[i];
  	  var div = "<div id='g+"+i+"'>";
  	  $('#google').append(div);
  	  gapi.post.render("g+"+i, {'href' : url} );
  	}
  })
});