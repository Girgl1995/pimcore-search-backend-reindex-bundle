pimcore.registerNS('pimcore.SearchBackendReindex.menuItem');

pimcore.SearchBackendReindex.menuItem = {

    requestSearchBackendReindex: function () {
        Ext.Ajax.request({
            url: Routing.generate('search_backend_reindex'),

            success: function (response) {
                const success = JSON.parse(response.responseText).success;

                if (!success) {
                    Ext.MessageBox.alert(
                        t('message'),
                        t('reindex_already_running')
                    );

                    return;
                }

                Ext.MessageBox.alert(
                    t('message'),
                    t('reindex_started')
                );
            }
        });
    },

    addSearchBackendReindexMenuItem: function () {
        var searchMenu = pimcore.globalmanager
            .get('layout_toolbar')
            .searchMenu;

        const reindexMenuItem = Ext.create('Ext.menu.Item', {
            text: t('search_backend_reindex'),
            iconCls: 'reindex_icon_refresh',
            cls: 'reindex-button',
            hideOnClick: true,
            handler: this.requestSearchBackendReindex
        });

        searchMenu.add(reindexMenuItem);
    }

};
