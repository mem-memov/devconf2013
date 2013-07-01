Ext.ns("Ext.remote");
Ext.remote.REMOTING_API = {
	"url": "\/server\/Doctor\/Remote\/main.php",
	"namespace": "Ext.remote",
	"type": "remoting",
	"actions": {
		"Html": [
			{
				"name": "create",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "read",
				"len": 0,
				"formHandler": false
			},
			{
				"name": "update",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "destroy",
				"len": 1,
				"formHandler": false
			}
		],
		"Menu": [
			{
				"name": "appendList",
				"len": 2,
				"formHandler": false
			},
			{
				"name": "appendReference",
				"len": 2,
				"formHandler": false
			},
			{
				"name": "readMenu",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "updateMenu",
				"len": 4,
				"formHandler": false
			},
			{
				"name": "destroyMenu",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "updatePositions",
				"len": 3,
				"formHandler": false
			},
			{
				"name": "create",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "read",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "update",
				"len": 1,
				"formHandler": false
			},
			{
				"name": "destroy",
				"len": 1,
				"formHandler": false
			}
		]
	}
};
