if ($(".table").length > 0){
	$('.table__top').on("click", function(){
		$(this).parent().toggleClass('active');
		if( $(this).parent().hasClass('active')) {
			$(this).next().slideDown();
		} else {
			$('.table__content').slideUp();
			$(".table").removeClass("active");
		}
	});
	/*$(function ($) {
		$(document).mouseup(function (e) {
		var div = $(".table.active");
		if (!div.is(e.target) && div.has(e.target).length === 0) {
				div.removeClass("active");
			}
		});
	});
	$(function ($) {
		$(document).mouseup(function (e) {
			var div = $(".table__content");
			if (!div.is(e.target) && div.has(e.target).length === 0) {
				div.slideUp();
			}
		});
	});*/

	new AirDatepicker('.date');
	new AirDatepicker('.date-birthday');
}