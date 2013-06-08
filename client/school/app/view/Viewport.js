Ext.define('school.view.Viewport', {

	extend: 'Ext.container.Viewport',

	alias: 'widget.school-viewport',

	layout: 'border',

	items: [
		{
//            xtype: 'panel',
            region: 'center',
            layout: 'fit',
            bodyStyle: { 
                backgroundImage: 'url(resources/images/school/hogwarts_yard_at_day.png)',
                backgroundPosition: 'right bottom',
                backgroundSize: 'cover'
            },
            items: [
                {
                    xtype: 'school-authentication',
                    autoShow: true
                }, {
                    xtype: 'school-assessment-tool',
                    hidden: true
                }
            ]
        }
	]

});
