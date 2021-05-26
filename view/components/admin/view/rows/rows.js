'use strict';

arikaim.component.onLoaded(function() {
    safeCall('adsView',function(obj) {
        obj.initRows();
    },true);    
});