$(document).ready(function(){
  $.getJSON("/github", function(data){
  	$('#loader').hide();
  	for(i in data){
  	var div ="";
  	if(typeof(data[i].repo) != "undefined" && data[i].repo !== null)
  	{
  	div +='<div class="github-card" data-user="'+data[i].username+'" data-repo="'+data[i].repo+'"data-width="400" data-height="150"></div><script src="http://lab.lepture.com/github-cards/widget.js"></script>';

  	}
  	$('#github').append(div);
  	}
  })
});