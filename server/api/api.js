Ext.ns("Ext.remote");
Ext.remote.REMOTING_API = {
	"url": "\/server\/School\/Remote\/main.php",
	"namespace": "Ext.remote",
	"type": "remoting",
	"actions": {
		"Test": [
			{
				"name": "doit",
				"len": 2
			}
		]
	}
};
Ext.ns("Ext.remote.subfolder");
Ext.remote.subfolder.REMOTING_API = {
	"url": "\/server\/School\/Remote\/Subfolder\/main.php",
	"namespace": "Ext.remote.subfolder",
	"type": "remoting",
	"actions": {
		"Test": [
			{
				"name": "doit_differently",
				"len": 1
			}
		]
	}
};
