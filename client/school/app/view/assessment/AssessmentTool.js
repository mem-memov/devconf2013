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
            //
            xtype: 'panel',
            flex: 1,
            border: false,
            layout: {
                type: 'vbox',
                align: 'stretch'
            },
            items: [
                {
                    xtype: 'school-student-list',
                    flex: 2
                }, {
                    xtype: 'school-rating',
                    flex: 1
                }
            ]
        }, {
            xtype: 'panel',
            flex: 2,
            layout: {
                type: 'vbox',
                align: 'stretch'
            },
            items: [
                {
                    xtype: 'school-student-profile',
                    flex: 1,
                    border: false,
                    hidden: true
                }, {
                    xtype: 'school-assessment-list',
                    flex: 1,
                    border: false,
                    hidden: true
                }
            ]
        }
    ]
    
});