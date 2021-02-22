'use strict';

arikaim.component.onLoaded(function() {
    $('#ads_dropdown').dropdown({
        onChange: function(value, text, choice) { 
            arikaim.page.loadContent({
                id: 'ad_form_content',
                component: 'ads::admin.form',
                params: { uuid: value }
            },function(result) {
                adsControlPanel.initAdsForm();
            });
        }
    });
      
    adsControlPanel.initAdsForm();    
});