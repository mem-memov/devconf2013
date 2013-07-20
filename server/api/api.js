Ext.ns("Ext.remote");
Ext.remote.REMOTING_API = {
	"url": "\/server\/Doctor\/Remote\/main.php",
	"namespace": "Ext.remote",
	"type": "remoting",
	"actions": {
		"Authentication": [
			{
				"name": "loginFormHandler",
				"len": 1,
				"formHandler": true
			}
		],
		"Html": [
			{
				"name": "read",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "update",
				"len": 1,
				"formHandler": false
			}
		],
		"Menu": [
			{
				"name": "createMenuItem",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "deleteMenuItem",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "updateMenuItem",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "readMenu",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "updatePositions",
				"len": 3,
				"formHandler": false
			}
		]
	}
};
