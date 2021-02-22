'use strict';

arikaim.component.onLoaded(function() {

    console.log('loaded rows: ' +  window['arikaimComponentName']);

    safeCall('adsView',function(obj) {
        obj.initRows();
    },true);    
});