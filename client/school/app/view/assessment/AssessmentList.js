Ext.define('school.view.assessment.AssessmentList', {

	extend: 'Ext.grid.Panel',

	alias: 'widget.school-assessment-list',
    
    requires: [
        'Ext.grid.plugin.RowEditing'
    ],

    plugins: [
        {
            ptype: 'rowediting',
            pluginId: 'school-assessment-edit-plugin-id',
            clicksToMoveEditor: 1,
            autoCancel: false
        }
    ],
    
    selType: 'rowmodel',
    selModel: {
        mode: 'SINGLE',
        allowDeselect: true
    },
    
    columns: [
        { 
            xtype: 'datecolumn',
            text: 'Дата', 
            dataIndex: 'date',
            format: 'd.m.Y',
            flex: 1
        }, {
            text: 'Оценка', 
            dataIndex: 'grade',
            flex: 1,
            editor: {
                xtype: 'combobox',
                editable: false,
                enableKeyEvents: true,
                matchFieldWidth: false,
                store: {
                    type: 'school-grade-store',
                    autoLoad: true
                },
                queryMode: 'local',
                displayField: 'grade',
                valueField: 'grade',
                listeners: {
                    select: function(gradeCombobox, comboboxRecords) {
                        
                        var assessmentList = gradeCombobox.up('school-assessment-list');
                        
                        assessmentList.fireEvent('school-grade-selected', 
                            assessmentList, // таблица успеваемости
                            gradeCombobox, // список названий оценок
                            comboboxRecords[0], // выбранная из списка оценок запись
                            assessmentList.getSelectionModel().getSelection()[0] // редактируеая строка таблицы таблицы
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
        '->',
        {
            text: 'Добавить',
            componentCls: 'add-button'
        }, {
            text: 'Удалить',
            componentCls: 'remove-button',
            disabled: true
        }
    ]
    
});