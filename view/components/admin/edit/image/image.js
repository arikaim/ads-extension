'use strict';

arikaim.component.onLoaded(function() {
    var uuid = $('#ads_edit_content').attr('uuid');

    arikaim.events.on('image.upload',function(params) {      
        arikaim.page.loadContent({
            id: 'ads_edit_content',
            component: 'ads::admin.edit.image',
            params: { uuid: uuid }
        });
    },'adsImageUplaod');

    arikaim.events.on('image.delete',function(params) {      
        arikaim.page.loadContent({
            id: 'ads_edit_content',
            component: 'ads::admin.edit.image',
            params: { uuid: uuid }
        });
    },'adsImageDelete');

    arikaim.ui.form.addRules("#link_form");

    arikaim.ui.form.onSubmit("#link_form",function() {  
        return adsControlPanel.updateBanner('#link_form');
    },function(result) {
        arikaim.ui.form.showMessage(result.message);       
    });
});