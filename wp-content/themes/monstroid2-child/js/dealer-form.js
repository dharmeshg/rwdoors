jQuery(function($){
	$(".btn-step").click(function () {
		$(this).next('.step').slideToggle();
		$(this).toggleClass('closed');
	});
});
