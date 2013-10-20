$(document).ready(function(){
	$.getJSON("/facebook", function(data){
		console.log(data);
		picture_url = data.me.picture.data.url;
		$('.fbImg').html('<image src="'+picture_url+'">');
		data = data.posts;
		div=''
		linkCount = 0;
		statusCount = 0;
		photoCount = 0;
		postCount = 0;
		for(i in data){
			var msg='';
			if(data[i].description!=null){
				msg = data[i].description
				if(msg.indexOf('like') != -1){
					if(msg.indexOf('link'))
						linkCount++;
					if(msg.indexOf('photo') != -1)
						photoCount++;
					if(msg.indexOf('status') != -1)
						statusCount++;
					if(msg.indexOf('post') != -1)
						postCount++;
				}
				else if(data[i].permalink){
					if(msg != "")
						var div = div+"<div class='fbpost'>"+msg+"<a class='fblink' href = '"+data[i].permalink+"'>Link</a></div>";
				}
				else if(msg != "")	
					var div = div+"<div class='fbpost'>"+msg+"</div>";
			}
			else {		
				msg = data[i].message;	
				if(data[i].permalink)
					if(msg != "")	
						var div = div+"<div class='fbpost'>"+msg+"<a class='fblink' href = '"+data[i].permalink+"'></a></div>";
				else{
					if(msg != "")	
						var div = div+"<div class='fbpost'>"+msg+"</div>";
				}
			}
		}
		$('#fb').append(div);
		var ctx = document.getElementById("fbLikes").getContext("2d");
		var data = [
			{
				value: linkCount,
				color:"#f39c12"
			},
			{
				value : photoCount,
				color : "#9b59b6"
			},
			{
				value : statusCount,
				color : "#1abc9c"
			},
			{
				value : postCount,
				color : "#c0392b"
			}
		]
		var myNewChart = new Chart(ctx).Doughnut(data);
		$('.linksval').html('Links: '+linkCount);
		$('.photosval').html('Photos: '+photoCount);
		$('.statusval').html('Statuses: '+statusCount);
		$('.postsval').html('Posts: '+postCount);

	})
});