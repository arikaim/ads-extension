'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.onSubmit("#ads_form",function() {  
        return adsControlPanel.update('#ads_form');
    },function(result) { 
        var msg = result.message;

        arikaim.page.loadContent({
            id: 'ads_tab_content',
            component: 'ads::admin.edit.tabs',
            params: { uuid: result.uuid }
        },function(result) {
            arikaim.ui.form.showMessage(msg);  
        });              
    });
});