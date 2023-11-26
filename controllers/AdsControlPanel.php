<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Ads\Controllers;

use Arikaim\Core\Controllers\ControlPanelApiInterface;
use Arikaim\Core\Controllers\ControlPanelApiController;
use Arikaim\Core\Db\Model;

use Arikaim\Core\Controllers\Traits\Status;

/**
 * Ads control panel controller
*/
class AdsControlPanel extends ControlPanelApiController implements ControlPanelApiInterface
{
    use Status;

    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {
        $this->loadMessages('ads::admin.messages');
        $this->setExtensionName('ads');
        $this->setModelClass('Ads');
    }

    /**
     *  Create new ad
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function addController($request, $response, $data) 
    {       
        $data           
            ->addRule('text:min=2|required','title')           
            ->validate(true);  
    
        $model = Model::Ads('ads');
        
        if ($model->hasAd($data['title']) == true) {
            $this->error('errors.exist');
            return false;
        }

        $newModel = $model->createAd($data['title'],$data['code'],$data['description']);
        if ($newModel == null) {
            $this->error('errors.add','Error create ad');
            return false;
        }
                                  
        $this
            ->message('add')
            ->field('uuid',$newModel->uuid);                         
    }

    /**
     * Update ad
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function updateController($request, $response, $data) 
    {     
        $data           
            ->addRule('text:min=2|required','title')                        
            ->validate(true); 

        $uuid = $data->get('uuid');
        $model = Model::Ads('ads');

        $exists = $model->where('title','=',$data['title'])->where('uuid','<>',$uuid)->exists();
        if ($exists == true) {
            $this->error('errors.exist');
            return false;
        }

        $ad = $model->findById($uuid);
        $result = $ad->update($data->toArray());
            
        $this->setResponse($result,function() use($uuid) {                                
            $this
                ->message('update')
                ->field('uuid',$uuid);                         
        },'errors.update');      
    }
   
    /**
     * Delete ad
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function deleteController($request, $response, $data)
    { 
        $data->validate(true);

        $uuid = $data->get('uuid');
        $model = Model::Ads('ads')->findByid($uuid);

        $result = $model->delete();

        $this->setResponse(($result !== false),function() use($uuid) {            
            $this
                ->message('delete')
                ->field('uuid',$uuid);  
        },'errors.delete');
    }

    /**
     * Update code
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function updateCodeController($request, $response, $data) 
    {       
        $data           
            ->addRule('text:min=2','uuid')                                         
            ->validate(true);   
       
        $uuid = $data->get('uuid');
        $code = $data->get('code',null);
        $model = Model::Ads('ads')->findById($uuid);
        if ($model == null) {
            $this->error('errors.id','Not valid ads id.');
            return false;
        }

        $result = $model->update(['code' => $code]);
            
        $this->setResponse($result,function() use($model) {                                
            $this
                ->message('update')
                ->field('uuid',$model->uuid);                         
        },'errors.update');  
    }

    /**
     * Update banner
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function updateBannerController($request, $response, $data) 
    {       
        $data           
            ->addRule('text:min=2','uuid')                        
            ->validate(true);  
    
        $uuid = $data->get('uuid');
        $linkUrl = $data->get('link_url',null);
        $model = Model::Ads('ads')->findById($uuid);
        if ($model == null) {
            $this->error('errors.id');
            return false;
        }

        $result = $model->update(['link_url' => $linkUrl]);
            
        $this->setResponse(($result !== false),function() use($model) {                                
            $this
                ->message('update')
                ->field('uuid',$model->uuid);                         
        },'errors.update');  
    }
}
