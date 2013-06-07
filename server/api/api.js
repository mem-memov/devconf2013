Ext.ns("Ext.remote");
Ext.remote.REMOTING_API = {
	"url": "\/server\/School\/Remote\/main.php",
	"namespace": "Ext.remote",
	"type": "remoting",
	"actions": {
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
		]
	}
};
