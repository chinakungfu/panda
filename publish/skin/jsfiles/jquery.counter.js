(function($) {

	$.fn.counter = function(options) {
		var defaultOption = {
			time: (10).minutes().fromNow(),
			day: ".day",
			hour: ".hour",
			minute: ".minute",
			second: ".second",
			create: false
		};

		options = $.fn.extend(defaultOption, options);

		var day = options.day;
		var hour = options.hour;
		var minute = options.minute;
		var second = options.second;
		var create = options.create;
		$(this).each(function() {
			if($(day, this).length) {
				day = $(day, this).eq(0);
			}
			else {
				day = $(document.createElement("span")).addClass("day");
				if(create)
					$(this).append(day);
			}
			if($(hour, this).length) {
				hour = $(hour, this).eq(0);
			}
			else {
				hour = $(document.createElement("span")).addClass("hour");
				if(create)
					$(this).append("D").append(hour);
			}
			if($(minute, this).length) {
				minute = $(minute, this).eq(0);
			}
			else {
				minute = $(document.createElement("span")).addClass("minute");
				if(create)
					$(this).append(":").append(minute);
			}
			if($(second, this).length) {
				second = $(second, this).eq(0);
			}
			else {
				second = $(document.createElement("span")).addClass("second");
				if(create)
					$(this).append(":").append(second);
			}
			//var self = $(this);
			updateDisplay = (function(){
				var t = options.time;
				var now = new Date();
				var interval = t.getTime() - now.getTime();

				if(interval <= 0) {
					interval = 0;
				}

				var msecPerMinute = 1000 * 60;
				var msecPerHour = msecPerMinute * 60;
				var msecPerDay = msecPerHour * 24;

				var days = Math.floor(interval / msecPerDay );
				interval = interval - (days * msecPerDay );
				
				var hours = Math.floor(interval / msecPerHour );
				interval = interval - (hours * msecPerHour );
				
				var minutes = Math.floor(interval / msecPerMinute );
				interval = interval - (minutes * msecPerMinute );

				seconds = Math.floor(interval / 1000 );
				day.text(days);
				hour.text(hours);
				minute.text(minutes);
				second.text(seconds);
			});
			updateDisplay();
			setInterval(updateDisplay, 1000);
		});
	}
}(jQuery));
