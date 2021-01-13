'use strict';

$(document).ready(function() {

    $('#ads_dropdown').dropdown({
        onChange: function(value, text, choice) { 
            arikaim.page.loadContent({
                id: 'details_content',
                component: 'ads::admin.details.content',
                params: { uuid: value }
            },function(result) {
               
            });
        }
    });  
});