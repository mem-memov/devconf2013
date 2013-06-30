Ext.define('Doctor.controller.ViewportController', {
    
    extend: 'Ext.app.Controller',
    
    selectors: {
        viewport: 'app-viewport',
        menuContainer: 'panel[ItemId="menu-container"]',
        contentContainer: 'panel[ItemId="content-container"]'
    },

    init: function () {

        var eventPool = {
            component: {}
        };

        eventPool.component[this.selectors.viewport] = {
            afterrender: this.afterRender
        }

        this.listen(eventPool);
        
    },

    afterRender: function(viewport) {

        var menuContainer = this.fetchMenuContainer(viewport);
        var contentContainer = this.fetchContentContainer(viewport);
        
        var length = menuContainer.getWidth();
        var duration = 2000;
        
        menuContainer.animate({
            to: {
                x: 0
            },
            duration: duration
        });
        
        contentContainer.animate({
            from: {
                opacity: 0
            },
            to: {
                x: length,
                opacity: 0
            },
            duration: duration,
            callback: function() {
                contentContainer.ownerCt.doComponentLayout(); // устраняем заход за правый край экрана
            }
        });
        
        contentContainer.animate({
            from: {
                opacity: 0
            },
            to: {
                opacity: 1
            },
            duration: duration
        });

    },
    
    fetchMenuContainer: function(viewport) {
        
        return viewport.down(this.selectors.menuContainer);
        
    },
    
    fetchContentContainer: function(viewport) {
        
        return viewport.down(this.selectors.contentContainer);
        
    }    
    
});
