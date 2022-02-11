'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.onSubmit("#ads_form_code",function() {  
        return adsControlPanel.updateCode('#ads_form_code');
    },function(result) {
        arikaim.ui.form.showMessage(result.message);       
    });
});