


setInterval(function(){

	$( ".field-repeater" ).each(function() {

		if ($( this ).attr('data-max-items')=='1')
		{
			if ($( this ).children("ul").children("li").length)
			{
				$( this ).children(".field-repeater-add-item").hide();
			}
		}
	});

}, 500);
