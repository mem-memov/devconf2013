Ext.define('school.view.assessment.AssessmentTool', {

	extend: 'Ext.panel.Panel',

	alias: 'widget.school-assessment-tool',
    
    title: 'school-assessment-tool',
    
    layout: {
        type: 'hbox',
        align: 'stretch'
    },
    
    items: [
        {
            xtype: 'school-student-list',
            flex: 1
        }, {
            xtype: 'school-grade-list',
            flex: 1
        }
    ]
    
});