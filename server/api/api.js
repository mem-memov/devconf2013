Ext.ns("Ext.remote");
Ext.remote.REMOTING_API = {
	"url": "\/server\/School\/Remote\/main.php",
	"namespace": "Ext.remote",
	"type": "remoting",
	"actions": {
		"Assessment": [
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
		],
		"Authentication": [
			{
				"name": "loginFormHandler",
				"len": 2,
				"formHandler": true
			}
		],
		"Grade": [
			{
				"name": "readAll",
				"len": 0,
				"formHandler": false
			}
		],
		"Professor": [
			{
				"name": "readNameList",
				"len": 0,
				"formHandler": false
			}
		],
		"Student": [
			{
				"name": "readNameList",
				"len": 0,
				"formHandler": false
			}
		]
	}
};
