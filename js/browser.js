require(
	["TopWidget","BrowserWidget"], //require
	function(){
//		topT.max = 10;
		var browser = new BrowserWidget();
		var topT = new TopWidget("times");
		$("#main").appendWidget(browser);
		$("#right").appendWidget(topT);
        //$("#main").doWidgets(); <-- selective same or any wrapper
        $.ui.doWidgets(); //<--global
	}
);
