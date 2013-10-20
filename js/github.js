$(document).ready(function(){
  $.getJSON("/github", function(data){
  	$('#loader').hide();
     arr = []; arr1 = [];
  	for(i in data){
  	var div ="";
  	
  	 if(typeof(data[i].repo) != "undefined" && data[i].repo !== null)
  	 {
  	 div ='<div><a href="'+data[i].link+'">'+$.trim(data[i].text)+'</a></div><div class="github-card" data-user="'+data[i].username+'" data-repo="'+data[i].repo+'"data-width="400" data-height="150"></div><script src="http://lab.lepture.com/github-cards/widget.js"></script>';
  	 arr.push(div);
  	 }
  	
  	arr1 = _.uniq(arr);
    
    }
  	for (var i = arr1.length - 1; i >= 0; i--) {
  	$('#github').append(arr1[i]);
  
  	};
  })
});