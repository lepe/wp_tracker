var UI = Class.extend({
    elem : null,
    baseurl  : "/php/proxy.php",
    widgets : [],
    //Initialize the Widget with initparam (used to recycle widget)
    init: function() {
    },
    //------------ PRIVATE --------------
    //Retrieve data from server
    _query : function(widget, callback) {
        widget.params.cat = widget.category;
        $.getJSON(this.baseurl, widget.params).done(function(data) {
            callback(data);
        });
    },
    _getTemplate : function(widget, callback) {
        $.get("/htm/"+widget.template+".htm").done(function(res){
            widget.html = res;
            callback();
        });
    },
    //Apply data and directives into the template and insert it 
    _transform : function(widget, set, callback) {
        $html = $(widget.html);
        //When there is no child in template (single element), we
        //insert the element into the selector and then apply render 
        if($html.children().length === 0) {
            $(widget.parent)[widget.action]($html).render(set.content, set.directives);
        } else {
            $html.render(set.content, set.directives);
            $(widget.parent)[widget.action]($html);
        }
        if(callback !== undefined) callback($html);
    },
    //------------ PUBLIC ---------------
    addWidget: function(action, widget, elem) {
        widget.parent = elem;
        widget.action = action;
        this.widgets.push(widget);
        return elem;
    },
    updWidget: function() {

    },
    doWidgets: function($parent) {
        var ui = this;
        for(var w in this.widgets) {
            var widget = ui.widgets[w];
            ui._getTemplate(widget, function() {
                widget.setup();
                ui._query(widget, function(data) {
                    widget.render(data,function(set, callback) {
                        ui._transform(widget, set, callback);
                    });
                });
            });
        }
    }
});
jQuery.ui = new UI();
jQuery.fn.appendWidget = function(widget) {
    return jQuery.ui.addWidget("append", widget, this);
}
jQuery.fn.prependWidget = function(widget) {
    return jQuery.ui.addWidget("prepend", widget, this);
}
jQuery.fn.addWidget = function(widget) {
    return jQuery.ui.addWidget("html", widget, this);
}
jQuery.fn.doWidgets = function() {
    return jQuery.ui.doWidgets($(this));
}