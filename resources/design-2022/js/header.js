// Main menu open
$('.header__burger').on("click", function (event) {
	$('body').toggleClass('lock');
	$('.sidebar-container').toggleClass('active');
});

$('.js-close').on("click", function () {
	$(this).closest('.attention-card').fadeOut(300);
});
