Ext.define('school.view.profile.Student', {
    
    extend: 'Ext.panel.Panel',
    
    alias: 'widget.school-student-profile',
    
    title: 'Карточка учащегося',
    
    layout: {
        type: 'hbox',
        align: 'stretch'
    },
    
    items: [
        {
            xtype: 'school-student-card',
            flex: 1
        }, {
            xtype: 'school-student-activity-chart',
            width: 300
        }
    ]
    
});