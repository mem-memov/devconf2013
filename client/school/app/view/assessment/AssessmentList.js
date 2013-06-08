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
            flex: 1,
            editor: {
                xtype: 'datefield',
                format: 'd.m.Y',
                showToday: false,
                minValue: new Date(1991, 9, 1),
                maxValue: new Date(1992, 6, 30) 
            }
        }, {
            text: 'Оценка', 
            dataIndex: 'grade',
            flex: 1,
            editor: {
                xtype: 'combobox',
                editable: false,
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
        type: 'school-assessment-store',
        sortOnLosd: true,
        sorters: [{
            property: 'date',
            direction: 'DESC'
        }]
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