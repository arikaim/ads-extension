/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
*/
'use strict';

/**
 * 
 * @class AdsView
 * @inherit ControlPanelView
 */
function AdsView() {   
    var self = this;

    this.init = function() {
        this.loadMessages('ads::admin');
        paginator.init('ads_rows');    
    };

    this.initRows = function() {    
      
        $('.status-dropdown').dropdown({
            onChange: function(value) {
                var uuid = $(this).attr('uuid');
                adsControlPanel.setStatus(uuid,value);               
            }
        });

        arikaim.ui.button('.delete-button',function(element) {
            var uuid = $(element).attr('uuid');
            var title = $(element).attr('data-title');
            var message = arikaim.ui.template.render(self.getMessage('remove.content'),{ title: title });

            modal.confirmDelete({ 
                title: self.getMessage('remove.title'),
                description: message
            },function() {
                adsControlPanel.delete(uuid,function(result) {
                    arikaim.ui.table.removeRow('#row_' + result.uuid);     
                });
            });
        });

        arikaim.ui.button('.edit-button',function(element) {
            var uuid = $(element).attr('uuid');
            arikaim.ui.setActiveTab('#edit_ad','.ads-tab-item');

            arikaim.page.loadContent({
                id: 'ads_content',
                component: 'ads::admin.edit',
                params: { uuid: uuid }
            }); 
        });

        arikaim.ui.button('.details-button',function(element) {
            var uuid = $(element).attr('uuid');
            arikaim.ui.setActiveTab('#details_ad','.ads-tab-item');

            arikaim.page.loadContent({
                id: 'ads_content',
                component: 'ads::admin.details',
                params: { uuid: uuid }
            }); 
        });
    }
}

var adsView = createObject(AdsView,ControlPanelView);

arikaim.component.onLoaded(function() {
    adsView.init();   
    adsView.initRows();
});