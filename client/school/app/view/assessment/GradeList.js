Ext.define('school.view.assessment.GradeList', {

	extend: 'Ext.grid.Panel',

	alias: 'widget.school-grade-list',

    plugins: [
        Ext.create('Ext.grid.plugin.RowEditing', {
            pluginId: 'school-grade-edit-plugin-id',
            clicksToMoveEditor: 1,
            autoCancel: false
        })
    ],
    
    columns: [
        { 
            xtype: 'datecolumn',
            text: 'Дата', 
            dataIndex: 'date',
            flex: 1
        }, {
            text: 'Оценка', 
            dataIndex: 'grade',
            flex: 1,
            editor: {
                xtype: 'combobox',
                componentCls: 'grade-list-combobox',
                allowBlank: false,
                editable: false,
                enableKeyEvents: true,
                matchFieldWidth: false,
                store: {
                    type: 'school-grade-store',
                    autoLoad: true
                },
                queryMode: 'local',
                displayField: 'grade',
                valueField: 'grade'
            }
        }
    ],
    
    store: {
        type: 'school-assessment-store'
    },
    
    tbar: [
        {
            text: 'Добавить',
            componentCls: 'add-button'
        }
    ]
    
});