Ext.define('school.view.assessment.GradeList', {

	extend: 'Ext.grid.Panel',

	alias: 'widget.school-grade-list',
    
//    layout: {
//        type: 'vbox',
//        align: 'left'
//    },
    
    columns: [
        { 
            xtype: 'datecolumn',
            text: 'Дата', 
            dataIndex: 'date',
            flex: 1
        }, {
//            xtype: 'gridcolumn',
            text: 'Оценка', 
            dataIndex: 'grade',
            flex: 1
        }
    ],
    
    store: {
        type: 'school-grade-store'
    }
    
});