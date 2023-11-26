<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Ads;

use Arikaim\Core\Extension\Extension;

/**
 * Ads extension
*/
class Ads extends Extension
{
    /**
     * Install extension routes, events, jobs ..
     *
     * @return void
    */
    public function install()
    {
        // Control Panel
        $this->addApiRoute('POST','/api/admin/ads/add','AdsControlPanel','add','session');   
        $this->addApiRoute('PUT','/api/admin/ads/update','AdsControlPanel','update','session');   
        $this->addApiRoute('PUT','/api/admin/ads/update/code','AdsControlPanel','updateCode','session');   
        $this->addApiRoute('PUT','/api/admin/ads/update/banner','AdsControlPanel','updateBanner','session');   
        $this->addApiRoute('DELETE','/api/admin/ads/delete/{uuid}','AdsControlPanel','delete','session');      
        $this->addApiRoute('PUT','/api/admin/ads/status','AdsControlPanel','setStatus','session');      
        // Api
        $this->addApiRoute('GET','/api/ads/link/{code}','AdsApi','openLink',null);   
        // Db tables
        $this->createDbTable('AdsSchema');  
        // Storage folder
        $this->createStorageFolder('public/images/ads',true);
        // Relation map 
        $this->addRelationMap('ads','Ads');
        // Services
        $this->registerService('Ads');
    }
    
    /**
     * UnInstall
     *
     * @return void
     */
    public function unInstall()
    {         
    }
}
