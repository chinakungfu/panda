	
var loving = 0;
function makeLove(love_id,user_id,type,love_button,love_img,event_love){
	if($(love_button).hasClass("disable_love")){	
		loving = 1;
		$.ajax({
			url : 'index.php',
			type : 'POST',
			dataType : "json",
			data:{
				action	: "website",
				method	: "memberLove",
				user_id : user_id,
				type : type,
				love_id : love_id,
				go : "remove"
			},
			success : function(data){
				if(love_img == false){
					$(".heart_love_count").text("("+ data +")");
					$(".love_it_button").removeClass("disable_love");
					$(".love_it_button").text("+Love it");
				}else{
					if(event_love != false){
						$(".love_count").text(data);
					}else{
						$(love_button).children(".love_count").text("Love ("+data+")");
					}
					$(love_button).children("img").attr("src","../skin/images/"+love_img);
					$(love_button).removeClass("disable_love");
				}
			},complete : function(){
				loving = 0;
			}
			});
		
	}else{
	loving = 1;
		$.ajax({
			url : 'index.php',
			type : 'POST',
			dataType : "json",
			data:{
				action	: "website",
				method	: "memberLove",
				user_id : user_id,
				type : type,
				love_id : love_id,
				go : "add"
			},
			success : function(data){
				if(love_img == false){
					$(".heart_love_count").text("("+ data +")");
					$(".love_it_button").addClass("disable_love");
					$(".love_it_button").text("-Love it");
				}else{
					if(event_love != false){
						$(".love_count").text(data);
					}else{
						$(love_button).children(".love_count").text("Loved ("+data+")");
					}
					$(love_button).children("img").attr("src","../skin/images/disable_"+love_img);
					$(love_button).addClass("disable_love");
				}
			
			},complete : function(){
				
				loving = 0;
			}
			});
		}
	}
