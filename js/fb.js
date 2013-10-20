$(document).ready(function(){
  $.getJSON("/facebook", function(data){
  	console.log(data);
  	picture_url = data.me.picture.data.url;
  	$('#fb').html('<image src="'+picture_url+'">');
  	data = data.posts;
  	div=''
  	for(i in data){
  	  var msg='';
  	  if(data[i].description!=null)
  	  	msg = data[i].description
  	  else
  	  	msg = data[i].message;
  	  if(data[i].permalink)
  	  	var div = div+"<div><a href = '"+data[i].permalink+"'>"+msg+"</a></div>";
  	  else
  	  	var div = div+"<div>"+msg+"</div>";
  	}
  	$('#fb').append(div);
  })
});