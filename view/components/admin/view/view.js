/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
*/
'use strict';

function AdsView() {   
    var self = this;

    this.init = function() {
        this.loadMessages('ads::admin');
        paginator.init('ads_rows');    

        arikaim.ui.loadComponentButton('.create-ad')
        adsView.initRows();
        
        arikaim.events.on('ads.create',function(uuid) {
            arikaim.page.loadContent({
                id: 'ads_rows',
                append: true,
                component: 'ads::admin.view.row',
                params: { uuid: uuid }
            },function() {
                self.initRows();
            }); 
        },'adsCreateHandler');

        arikaim.events.on('ads.update',function(uuid) {
            arikaim.page.loadContent({
                id: 'row_' + uuid,
                replace: true,
                component: 'ads::admin.view.row',
                params: { uuid: uuid }
            },function() {
                self.initRows();
            }); 
        },'adsUpdateHandler');
    };

    this.initRows = function() {    
        arikaim.ui.loadComponentButton('.ad-action')

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
        
            arikaim.page.loadContent({
                id: 'ads_details',
                component: 'ads::admin.edit',
                params: { uuid: uuid }
            }); 
        });

        arikaim.ui.button('.details-button',function(element) {
            var uuid = $(element).attr('uuid');
            arikaim.page.loadContent({
                id: 'ads_details',
                component: 'ads::admin.details',
                params: { uuid: uuid }
            }); 
        });
    }
}

var adsView = createObject(AdsView,ControlPanelView);

arikaim.component.onLoaded(function() {
    adsView.init();   
});