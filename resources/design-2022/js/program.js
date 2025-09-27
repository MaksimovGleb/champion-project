if ($(".program-referral").length > 0){
	$('.program-referral__btn').on("click", function myFunction() {
		var copyText = $('.program-referral__field');
		copyText.select();
		document.execCommand("copy");
	})
}