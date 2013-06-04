Ext.define('school.view.assessment.StudentList', {

	extend: 'Ext.grid.Panel',

	alias: 'widget.school-student-list',
    
//    layout: {
//        type: 'vbox',
//        align: 'left'
//    },
    
    columns: [
        { 
//            xtype: 'gridcolumn',
            text: 'Имя', 
            dataIndex: 'first_name',
            flex: 1
        }, {
//            xtype: 'gridcolumn',
            text: 'Фамилия', 
            dataIndex: 'last_name',
            flex: 1
        }, {
//            xtype: 'gridcolumn',
            text: 'Факультет', 
            dataIndex: 'house',
            flex: 1
        }
    ],
    
    store: {
        type: 'school-student-store'
    }
    
});