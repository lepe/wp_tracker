define(
	["Widget"],  //depends on
	function(){
		BrowserWidget = Widget.extend({
            template : "browser",
            category : "general",
            setup : function() {
            	this.params["browser"] = "";
            },
			render : function(data, callback) {
                callback({
                    models: data,
                    directives : {
                        browser : {
                              server: {
								'class' : function() {
									return this.ingame > 0 ? 'with' : '';
								}
							  },
							  type : {
                                text: function() { 
                                    return this.type; 
                                },
                                href: function() { 
                                    return "";
                                }
                              },
							  game : {
                                text: function() { 
                                    return this.game || "base"; 
                                },
                                href: function() { 
                                    return "";
                                }
                              },
							  country : {
                                text: function() { 
                                    return this.country; 
                                }
                              },
                              flag: {
                                src : function() { 
                                    return gt_plugin_path+"/img/countries/"+this.country.toLowerCase()+".png"; 
                                },
								alt : function() { 
                                    return this.country; 
                                },
								title : function() { 
                                    return this.country; 
                                }
                              },
							  ip : {
								title : function() { 
                                    return this.ip; 
                                },
								text : function() { return ""; }
							  },
							  name : {
								  'data-id' : function() {
									  return this.id;
								  },
								  href : function() {
									  return "?s="+this.id+"&"+this.name.decolorfy();
								  },
								  html: function(target) {
									  return (this.name || "^8Unnamed").colorfy();
								  }
							  },
							  players : {
								  title : function() {
									  return "spectators: "+this.spec;
								  }
							  },
							  current : {
								  href : function() {
									  return this.ingame > 0 ? "#" : null;
								  },
								  text : function() {
									  return (this.ingame || this.v_ingame)+" / "+this.max_players; //compatibility with alpha version TODO: remove v_ingame
								  }
							  },
							  bots : {
								  text : function(target) {
									  return this.bots > 0 ? "("+this.bots+")" : "";
								  },
								  title : function() {
									  return this.bots > 0 ? "Bots" : "";
								  }
							  },
							  map : {
								  href : function() {
									  return "#";
								  },
								  text : function() {
									  return "atcs";
								  }
							  },
							  rank : {
								  text: function() {
									  return "#"+this.rank;
								  }
							  }
                        }
                    }
                });
            }
        });
	}
);
