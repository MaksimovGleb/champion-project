(function(){
		$('.tabs-wrapper').each(function(){
			var $t = $(this);
			var $arrowLeft = function(){return $t.find(".tabs-extended .arrow-left")};
			var $arrowRight = function(){return $t.find(".tabs-extended .arrow-right")};

			$t.find(".js__tab").click(function () {
				$t.find(".js__tab").removeClass("active").eq($(this).index()).addClass("active");
				$t.find(".tab-content").hide().eq($(this).index()).fadeIn();
				arrowsCheck();
			});
			
			if($t.find(".js__tab.active").length == 0)
				$t.find(".js__tab").eq(0).click()
		
			function arrowsCheck()
			{
				var activeIndex = $t.find(".js__tab.active").index();
				var length = $arrowRight().parent().find('.js__tab').length;
				if(activeIndex == 0 || length == 0){
					$arrowLeft().addClass('fade');
				}else{
					$arrowLeft().removeClass('fade');
				}
				if(activeIndex == length-1){
					$arrowRight().addClass('fade');
				}else{
					$arrowRight().removeClass('fade');
				}
			}

			$arrowLeft().click(function () {
				var activeIndex = $t.find(".js__tab.active").index();

				var $toHide = $t.find(".js__tab:not(.hidden):last").eq(0);
				var index = $toHide.index();
				if(index > 2){
					$toHide.addClass('hidden');
					$t.find(".js__tab").eq(index-3).removeClass('hidden');
				}

				if(activeIndex > 0){
					$t.find(".js__tab").removeClass("active").eq(activeIndex-1).addClass("active");
					$t.find(".tab-content").hide().eq(activeIndex-1).fadeIn()
				}

				arrowsCheck();
			});

			$arrowRight().click(function () {
				var nextIndex = $t.find(".js__tab.active").index()+1;
				var length = $(this).parent().find('.js__tab').length;

				var $toHide = $t.find(".js__tab:not(.hidden)").eq(0);
				var index = $toHide.index();
				if(index < length-3){
					$toHide.addClass('hidden');
					$t.find(".js__tab").eq(index+3).removeClass('hidden');
				}

				if(nextIndex < length){
					$t.find(".js__tab").removeClass("active").eq(nextIndex).addClass("active");
					$t.find(".tab-content").hide().eq(nextIndex).fadeIn()
				}
				arrowsCheck();
			});

			arrowsCheck();
		});

	})();
