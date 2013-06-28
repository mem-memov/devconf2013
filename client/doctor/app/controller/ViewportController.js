Ext.define('doctor.controller.ViewportController', {
    
    extend: 'Ext.app.Controller',
    
    init: function () {

        this.listen({
            component: {
                'app-viewport': {
                    afterrender: this.onRender
                }
            }
        });
        
    },
    
    onRender: function(viewport) {
        
        var leftPart = viewport.down('[componentCls="left-part"]');
        var rightPart = viewport.down('[componentCls="right-part"]');
        
        leftPart.show();
        leftPart.animate({
            from: {
                x: -leftPart.getWidth()
            },
            to: {
                x: 0
            },
            duration: 2000
        });

    }
    
    
});
