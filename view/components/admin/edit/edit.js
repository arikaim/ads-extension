'use strict';

arikaim.component.onLoaded(function() {
    $('#ads_dropdown').dropdown({
        onChange: function(value, text, choice) { 
            arikaim.page.loadContent({
                id: 'ads_tab_content',
                component: 'ads::admin.edit.tabs',
                params: { uuid: value }
            });
        }
    });
});