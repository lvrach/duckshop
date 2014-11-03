/*jquery highlight*/
jQuery.fn.highlight=function(b){function a(e,j){var l=0;if(e.nodeType==3){var k=e.data.toUpperCase().indexOf(j);if(k>=0){var h=document.createElement("span");h.className="highlight";var f=e.splitText(k);var c=f.splitText(j.length);var d=f.cloneNode(true);h.appendChild(d);f.parentNode.replaceChild(h,f);l=1}}else{if(e.nodeType==1&&e.childNodes&&!/(script|style)/i.test(e.tagName)){for(var g=0;g<e.childNodes.length;++g){g+=a(e.childNodes[g],j)}}}return l}return this.each(function(){a(this,b.toUpperCase())})};jQuery.fn.removeHighlight=function(){return this.find("span.highlight").each(function(){this.parentNode.firstChild.nodeName;with(this.parentNode){replaceChild(this.firstChild,this);normalize()}}).end()};


$(document).ready(function () {
	
	function dict2array(d) {
		a = new Array();
		for( i in d ) {
		
			a.push({ key : i,
					 value: d[i] });
		}
		return a ;
	}
	
	var template = new Object();
	template.session  = Handlebars.compile($("#session-template").html());
	template.request  = Handlebars.compile($("#request-template").html());
	template.sql_query = Handlebars.compile($("#sql_query-template").html());
	template.request_post = Handlebars.compile($("#request-post").html());
	
	var socket = io.connect("http://" + location.host + "/monitor");	
	var last_phpsessid = "";

	socket.on("new-request", function(id, globals) {
		
		var phpsessid = globals.cookie['PHPSESSID'];

		if( last_phpsessid != phpsessid ) {

			$(".session-list").prepend(
				template.session({
					id: phpsessid
				})
			);
			last_phpsessid = phpsessid;
				
		}

		$(".s-"+phpsessid+"-session .request-list")			
			.prepend(template.request({
				id: id 
			}));	

		var s = dict2array(globals.session);
		console.log(globals.session);
		$(".s-"+phpsessid+"-session .session-info")
			.html(template.request_post({
					post: s
				}));	

		$(".u-"+id+ "-request .client-ip").text(globals.server['REMOTE_ADDR']);
		$(".u-"+id+ "-request .request-url").text(globals.server['REQUEST_URI']);
		$(".u-"+id+ "-request .method").text(globals.server['REQUEST_METHOD']);

		for (i in globals.get) {
			$(".u-"+id+ "-request .request-url").highlight('=' + globals.get[i]) ;
		}

		if(globals.server['REQUEST_METHOD'] == "POST") {
			
			var p = dict2array(globals.post);
			$(".u-"+id+ "-request .post")
				.append(template.request_post({
					post: p
				}));
		}
		
	});
	

	
	socket.on("add-sql", function(id, type, parameters, status, result) {
						
			console.log(parameters);
			if(type == "query") {

				var q = parameters["query"];
				$(".u-"+id+ "-request .sql")
					.append(template.sql_query({						
						query: q,
						status: status,
						result: result 
					}));
			}
		
	});	

	socket.on("highlight" , function(id, type, text) {
		if(type == "sql") { 
			$(".u-"+id+ "-request .sql .sql_query:last ").highlight(text);
		}

	});

	socket.on("log" , function(id, type, level, msg) {

		console.log('log: ' + type + '-' + msg);
		if(type == "title") {

			$(".u-"+id+ "-request .title ").html(msg);
		}

	});
	
});
