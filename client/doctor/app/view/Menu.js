Ext.define('doctor.view.Menu', {
    
    extend: 'Ext.panel.Panel',
    
    alias: 'widget.app-menu',

    layout: {
        type: 'accordion',
        titleCollapse: false,
        animate: true,
        activeOnTop: false
    },

    initComponent: function() {
        
        if (Ext.isString(this.store)) {
            this.store = Ext.StoreMgr.lookup(this.store);
        } else if (!this.store || Ext.isObject(this.store) && !this.store.isStore) {
            this.store = Ext.create('doctor.store.MenuStore', this.store);
            this.store.setRootNode({
                id: 1,
                text: '.',
                children: [
                    {
                        id: 2,
                        text: 'Alma Mater',
                        children: [
                            {
                                id: 5,
                                text: 'Факультеты',
                                leaf: true
                            }, {
                                id: 7,
                                text: 'Прфессора',
                                leaf: true
                            }
                        ]
                    },
                    {
                        id: 3,
                        text: 'Научная работа',
                        children: [
                            {
                                id: 10,
                                text: 'Дисертация',
                                leaf: true
                            }
                        ]
                    }
                ]
            });
        }

        var parentNode;
        if (!this.initialConfig.parentNodeId) {
            parentNode = this.store.getRootNode();
        } else {
            parentNode = this.store.getNodeById(this.initialConfig.parentNodeId);
        }

        if (!this.items) {
            this.items = this.buildItems(parentNode);
        }
        
        
        this.callParent(arguments);
        
    },
    
    buildItems: function(parentNode) {

        var items = [];
        
        parentNode.eachChild(function(node) {

            var nodeId = node.get('id');
            var nodeText = node.get('text');
            var parentNodeId = node.parentNode.get('id');
            
            if (!node.get('leaf')) {
                
                if (node.hasChildNodes()) {
                    
                    var firstChild = node.getChildAt(0);
                    
                    if (!firstChild.get('leaf')) {
                        
                        // вставляем аккордион
                        items.push({
                            xtype: 'app-menu',
                            title:  Ext.String.repeat('-', node.getDepth()-1) + nodeText,
                            parentNodeId: nodeId,
                            store: this.store,
                            node: node
                        });
                        
                    } else {
                        
                        // вставляем панель с кнопками
                        var panel = {
                            xtype: 'panel',
                            componentCls: 'app-menu-list',
                            title:  Ext.String.repeat('-', node.getDepth()-1) + nodeText,
                            layout: {
                                type: 'vbox',
                                align: 'stretch'
                            },
                            node: node
                        };
                        
                        // создаём кнопки
                        if (node.hasChildNodes()) {
                            panel.items = [];
                            node.eachChild(function(leafNode) {
                                panel.items.push({
                                    xtype: 'button',
                                    componentCls: 'app-menu-item',
                                    text: leafNode.get('text'),
                                    node: leafNode
                                });
                            });
                        }
                        
                        items.push(panel);
                        
                    }
                    
                }

            }
            
        });

        return items;
        
    }

});