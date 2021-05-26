'use strict';

arikaim.component.onLoaded(function() {
    $('.ads-type-dropdown').dropdown({
        onChange: function(value) {          
            $('.ads-type').hide();

            if (value == 'banner') {             
                $('#banner_type').show();
            }
            if (value == 'js') {
                $('#js_type').show();
            }
        }
    }); 
    
    arikaim.ui.form.addRules("#ads_form");
});