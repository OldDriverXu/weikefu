$(document).ready(function(){

	//左导航
	$('.col-xs-2 .left_nav li:has(a)').mouseover(function(){
		$(this).addClass('li_background');
	});
	$('.col-xs-2 .left_nav li:has(a)').mouseout(function(){
		$(this).removeClass('li_background');
	});

});