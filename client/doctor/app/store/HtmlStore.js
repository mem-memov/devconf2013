Ext.define('doctor.store.HtmlStore', {
    
    extend: 'Ext.data.Store',
    
    alias: 'store.app-html-store',

    model: 'doctor.model.HtmlModel',
    
    data: [
        { id: 1, html: '<img src="resources/images/portret.png" />' },
        { id: 2, html: '<p>Lorem ipsum</p>' }
    ]
    
});