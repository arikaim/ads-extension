/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
*/
'use strict';

function AdsView() {
    var self = this;

    this.init = function() {
        paginator.init('ads_rows');    
    };

    this.initRows = function() {    
        var component = arikaim.component.get('ads::admin');
        var removeMessage = component.getProperty('messages.remove.content');

        $('.status-dropdown').dropdown({
            onChange: function(value) {
                var uuid = $(this).attr('uuid');
                adsControlPanel.setStatus(uuid,value);               
            }
        });

        arikaim.ui.button('.delete-button',function(element) {
            var uuid = $(element).attr('uuid');
            var title = $(element).attr('data-title');

            var message = arikaim.ui.template.render(removeMessage,{ title: title });
            modal.confirmDelete({ 
                title: component.getProperty('messages.remove.title'),
                description: message
            },function() {
                adsControlPanel.delete(uuid,function(result) {
                    arikaim.ui.table.removeRow('#row_' + result.uuid);     
                });
            });
        });

        arikaim.ui.button('.edit-button',function(element) {
            var uuid = $(element).attr('uuid');
            arikaim.ui.setActiveTab('#ads_edit');

            arikaim.page.loadContent({
                id: 'ads_content',
                component: 'ads::admin.edit',
                params: { uuid: uuid }
            }); 
        });
    }
}

var adsView = new AdsView();

arikaim.page.onReady(function() {
    adsView.init();   
});