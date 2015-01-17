require(
	["TopWidget","BrowserWidget"], //require
	function(){
//		topT.max = 10;
		var browser = new BrowserWidget();
		$("#browser").appendWidget(browser);
        //$("#main").doWidgets(); <-- selective same or any wrapper
        $.ui.doWidgets(); //<--global
	}
);
