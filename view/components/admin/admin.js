/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function AdsControlPanel() {
  
    this.delete = function(uuid, onSuccess, onError) {
        return arikaim.delete('/api/admin/ads/delete/' + uuid,onSuccess,onError);          
    };

    this.add = function(formId, onSuccess, onError) {
        return arikaim.post('/api/admin/ads/add',formId,onSuccess,onError);          
    };

    this.update = function(formId, onSuccess, onError) {
        return arikaim.put('/api/admin/ads/update',formId,onSuccess,onError);          
    };

    this.updateCode = function(formId, onSuccess, onError) {
        return arikaim.put('/api/admin/ads/update/code',formId,onSuccess,onError);          
    };

    this.updateBanner = function(formId, onSuccess, onError) {
        return arikaim.put('/api/admin/ads/update/banner',formId,onSuccess,onError);          
    };

    this.setStatus = function(uuid, status, onSuccess, onError) { 
        var data = { 
            status: status,
            uuid: uuid 
        };
        
        return arikaim.put('/api/admin/ads/status',data,onSuccess,onError);           
    };  
}

var adsControlPanel = new AdsControlPanel();

arikaim.component.onLoaded(function() {
    arikaim.ui.tab();
});