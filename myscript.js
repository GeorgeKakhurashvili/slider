function alert_func(){
        
        width = $(window).width();
        height = $(window).height();
        width_min = width/2;
        height_min = height/2;
        $("#large_div img").css({"width": width, "height": height});
}

// function move_left()
// {
// 	var length = $("#large_div img").length;
// 	width = $(window).width();
//     height = $(window).height();
// 	$("#large_div").animate({left: width});
// }

		counter = 0;
		function move_forward()
		{

			$(document).ready(function()
			{
    			
        		
        		$("#image").fadeOut(300,
        			function fade_in()
						{
							if(counter===mass.length-1) { counter=-1;}
							$("#image").attr("src" , mass[++counter]);
							$("#image").fadeIn(300);
							if(counter===mass.length-1) { counter=-1;}
							
						});
        		
    		
			});
		}

		function move_backward()
		{

			$(document).ready(function()
			{
    			
        		
        		$("#image").fadeOut(300,
        			function fade_in()
						{
							if(counter===0) { counter=mass.length;}
							$("#image").attr("src" , mass[--counter]);
							$("#image").fadeIn(300);
							
							if(counter===0) { counter=mass.length;}

						});
        		
    		
			});
		}

		function slide_from_left()
		{
			if (counter == 0) {var min_counter = mass.length;}
			else{var min_counter = counter;}
			var url = mass[--min_counter];
			$(document).ready(function(){
			    
			    $("#left_position").animate({left: '0px'});
			    $("#left_position").css("background-image","url("+url+")");
			    $("#arrow_left").css("background-color","transparent");
			    
			});
		}
		function back_to_left()
		{
			$(document).ready(function(){
			    
			    $("#left_position").animate({left: '-250px'});
			    $("#arrow_left").css("background-color","white");
			    
			});
		}

		function slide_from_right()
		{
			if (counter == mass.length-1) {var min_counter = -1;}
			else{var min_counter = counter;}
			var url = mass[++min_counter];
			$(document).ready(function(){
			    
			    $("#right_position").animate({right: '0px'});
			    $("#right_position").css("background-image","url("+url+")");
			    $("#arrow_right").css("background-color","transparent");
			    
			});
		}
		function back_to_right()
		{
			$(document).ready(function(){
			    
			    $("#right_position").animate({right: '-250px'});
			    $("#arrow_right").css("background-color","white");
			    
			});
		}



		// function resize_img(id)
		// {
		// 	var a_id=id;
		// 	$("#"+a_id+" img").css({"width": "500px", "height": "500px"});
		// }
