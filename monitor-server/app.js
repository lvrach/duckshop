var io = require('socket.io').listen(8056);
var dnode = require('dnode');

var nextId = 0 ;

var server = dnode({
    
    start: function(setId) {
		setId(nextId);
		monitor.emit("new-request", nextId);
		console.log('^^^^^^^^^^^^^^^^^^^^^^');
		console.log('< connected id :' + nextId );
		nextId ++ ;
	},    
	report: function(type,level,msg) {
				
	},
	info: function(id,globals) {
		monitor.emit("new-request-more", id, globals);
		
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
server.listen(7070);



var monitor = io
	.of('/monitor')
	.on('connection', function(socket) {		
		
		
		
	});
		




