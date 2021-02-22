/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function AdsControlPanel() {
  
    this.delete = function(uuid, onSuccess, onError) {
        return arikaim.delete('/api/ads/admin/delete/' + uuid,onSuccess,onError);          
    };

    this.add = function(formId, onSuccess, onError) {
        return arikaim.post('/api/ads/admin/add',formId,onSuccess,onError);          
    };

    this.update = function(formId, onSuccess, onError) {
        return arikaim.put('/api/ads/admin/update',formId,onSuccess,onError);          
    };

    this.setStatus = function(uuid, status, onSuccess, onError) { 
        var data = { 
            status: status,
            uuid: uuid 
        };
        
        return arikaim.put('/api/ads/admin/status',data,onSuccess,onError);           
    };

    this.initAdsForm = function() {
        arikaim.ui.form.addRules("#ads_form");
        arikaim.ui.form.onSubmit("#ads_form",function() {  
            return adsControlPanel.update('#ads_form');
        },function(result) {          
            arikaim.ui.form.showMessage(result.message);        
        });
    }

    this.init = function() {    
        arikaim.ui.tab();
    };
}

var adsControlPanel = new AdsControlPanel();

arikaim.component.onLoaded(function() {
    adsControlPanel.init();
});