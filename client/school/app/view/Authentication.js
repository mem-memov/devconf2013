Ext.define('school.view.Authentication', {

	extend: 'Ext.window.Window',

	alias: 'widget.school-authentication',
    
    title: 'Авторизация',
    
    layout: {
        type: 'hbox',
        align: 'stretch'
    },
    
    closable: false,
    resizable: false,
    
    buttonAlign: 'center',
    
    buttons: [
        { 
            text: 'Вход',
            componentCls: 'submit-button'
        }
    ],

    items: [
        {
            xtype: 'form',
            componentCls: 'authentication-form',
            flex: 1,
            layout: 'vbox',
            trackResetOnLoad: true, // позволяет следить за изменениями в полях формы через событие dirtychange
            fieldDefaults: {
                labelPad: 10,
                labelAlign: 'top',
                width: 200,
                margin: '10 10 0 10'
            },
            items: [
                {
                    fieldLabel: 'Имя:',
                    xtype: 'combobox',
                    componentCls: 'professor-name-list',
                    valueField: 'id',
                    displayField: 'last_name',
                    queryMode: 'local',
                    store: {
                        type: 'school-professor-store'
                    }
                }, {
                    fieldLabel: 'Пароль:',
                    xtype: 'textfield',
                    inputType: 'password'
                }
            ]
        }, {
            xtype: 'image',
            src: 'resources/images/person/Albus_Dumbledore_300x400.png',
            width: 150,
            height: 200
        }
    ]
    
    
});