pimcore.registerNS('pimcore.SearchBackendReindex.startup');

pimcore.SearchBackendReindex.startup = Class.create({

    initialize: function () {
        document.addEventListener(
            pimcore.events.pimcoreReady,
            this.onPimcoreReady.bind(this)
        );
    },

    onPimcoreReady: function () {
        var user = pimcore.globalmanager.get('user');

        if (!user.isAllowed('search_backend_reindex')) {
            return;
        }

        pimcore.SearchBackendReindex.menuItem.addSearchBackendReindexMenuItem();
    },

});

new pimcore.SearchBackendReindex.startup();
