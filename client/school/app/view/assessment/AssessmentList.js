Ext.define('school.view.assessment.AssessmentList', {

	extend: 'Ext.grid.Panel',

	alias: 'widget.school-assessment-list',
    
    requires: [
        'Ext.grid.plugin.RowEditing'
    ],

    plugins: [
        {
            ptype: 'rowediting',
            pluginId: 'school-assessment-grade-edit-plugin-id',
            clicksToMoveEditor: 1,
            autoCancel: false
        }
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
                listeners: {
                    select: function(combobox, comboboxRecords) {
                        
                        var assessmentList = combobox.up('school-assessment-list');
                        
                        assessmentList.fireEvent('school-grade-selected', 
                            assessmentList, // таблица успеваемости
                            assessmentList.getSelectionModel().getSelection()[0], // запись таблицы
                            comboboxRecords[0].get('id') // ID оценки
                        );
                            
                    }
                }
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