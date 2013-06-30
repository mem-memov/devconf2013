Ext.define('Doctor.controller.HtmlPanelController', {
    
    extend: 'Ext.app.Controller',
    
    init: function () {
        
        this.store = Ext.create('Doctor.store.HtmlStore');
        this.store.load();
        
        this.listen({
            controller: {
                '*': {
                    'menu-item-selected': this.onMenuItemSelected,
                    'menu-division-expanded': this.onMenuDivisionSelected
                }
            }
        });
        
    },
    
    onMenuItemSelected: function(menuRecord) {
        
        if (menuRecord.get('link_type') != 'html') {
            return;
        }

        var htmlRecord = this.store.findRecord('id', menuRecord.get('link_id'));
        
        var htmlPanel = Ext.ComponentQuery.query('app-html-panel')[0];
        
        htmlPanel.animate({
            to: {
                opacity: 0
            }, 
            duration: htmlPanel.isUpdated ? 1000 : 0, // устраняем задержку первого показа
            callback: function() {
                
                htmlPanel.update(htmlRecord.get('html'));
                
                htmlPanel.isUpdated = true;
 
                htmlPanel.animate({
                    from: {
                        opacity: 1,
                        x: 1000
                    },
                    to: {
                        opacity: 1,
                        x: 250
                    },
                    duration: 2000
                });
                
            }
        });
        

        
    },
    
    onMenuDivisionSelected: function(menuRecord) {
        
        var htmlPanel = Ext.ComponentQuery.query('app-html-panel')[0];
        
        htmlPanel.animate({
            to: {
                opacity: 0
            },
            duration: htmlPanel.isUpdated ? 800 : 0, // устраняем задержку первого показа
            callback: function() {
                
                htmlPanel.update('<div style="width: 50%; margin: 10% auto; text-align: center; font-size: 7em;">' + menuRecord.get('text') + '</div>');
                
                htmlPanel.isUpdated = true;
                
                htmlPanel.animate({
                    from: {
                        opacity: 0
                    },
                    to: {
                        opacity: 1
                    },
                    duration: 1000
                });
                
            }
        });
        
    }
    
});