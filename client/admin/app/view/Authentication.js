Ext.define('Admin.view.Authentication', {

	extend: 'Ext.window.Window',

	alias: 'widget.app-authentication',
    
    title: 'Авторизация',
    
    autoShow: true,
    
    layout: {
        type: 'hbox',
        align: 'stretch'
    },
    
    closable: false,
    resizable: false,
    
    closeAction: 'hide', // http://stackoverflow.com/questions/16763860/extjs-type-error-el-is-null
    
    buttonAlign: 'center',
    
    buttons: [
        { 
            text: 'Вход',
            itemId: 'submit-button'
        }
    ],

    items: [
        {
            xtype: 'form',
            itemId: 'authentication-form',
            flex: 1,
            layout: 'vbox',
            fieldDefaults: {
                labelPad: 10,
                labelAlign: 'top',
                width: 200,
                margin: '10'
            },
            items: [
                {
                    fieldLabel: 'Пароль:',
                    xtype: 'textfield',
                    name: 'password',
                    itemId: 'password-field',
                    formBind: true,
                    inputType: 'password'
                }
            ],
            // конфигурация BasicForm
            api: {
                submit: 'Ext.remote.Authentication.loginFormHandler'
            }
        }
    ]
    
    
});