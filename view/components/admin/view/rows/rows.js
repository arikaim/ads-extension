'use strict';

$(document).ready(function() {
    safeCall('adsView',function(obj) {
        obj.initRows();
    },true);    
});