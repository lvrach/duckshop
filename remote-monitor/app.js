var express = require("express")
	,http = require('http') ;

var app = express();
var server = http.createServer(app);
var io = require('socket.io').listen(server);

var dnode = require('dnode');


/*express*/
server.listen(8080);
app.use(express.static(__dirname + '/static'));

/*dnode*/
var nextId = 0 ;
var dserver = dnode({
    
    start: function(setId) {
		setId(nextId);			
		console.log('connected id :' + nextId );
		nextId ++ ;
	},
	info: function(id,globals) {
		
		monitor.emit("new-request", id, globals);
	
	},    
	log: function(id, type, level, msg) {
		monitor.emit("log", id, type, level, msg);			
	},	
	highlight : function(id, type, text) {
		monitor.emit("highlight", id, type, text);
		
	},
	includeLog : function(id, type, file) {	
		monitor.emit("add-include", id, type, file);
		console.log( type + '(' + file + ')');
					
	},
	sqlLog: function(id, type, parameters, status, result) {
		
		monitor.emit("add-sql",id, type, parameters, status, result);
		
	},
	stop: function() {
		
		console.log('vvvvvvvvvvvvvvvvvvvvvv');
	} 
});
dserver.listen(7070);


/*socket.io*/
var monitor = io
	.of('/monitor')
	.on('connection', function(socket) {		
		
		
		
	});
		




