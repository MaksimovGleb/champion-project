if ($(".profile-passwords").length > 0){
	$('.profile-passwords__icon').on("click", function(){
		if($(this).parent().hasClass("active")){
			$(this).parent().removeClass('active');
			$(this).parent().find('.profile-passwords__field').attr('type','password');
		} else {
			$(this).parent().addClass('active');
			$(this).parent().find('.profile-passwords__field').attr('type','text');
		}
	});
}