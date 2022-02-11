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
    }

    /**
     * Constructor
     * 
     * @param Container|null $container
     */
    public function __construct($container = null)
    {
        parent::__construct($container);
        
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
        $this->onDataValid(function($data) {            
            $model = Model::Ads('ads');
           
            if ($model->hasAd($data['title']) == true) {
                $this->error('errors.exist');
                return;
            }

            $newModel = $model->createAd($data['title'],$data['code'],$data['description']);
                    
            $this->setResponse(\is_object($newModel),function() use($newModel) {                                
                $this
                    ->message('add')
                    ->field('uuid',$newModel->uuid);                         
            },'errors.add');
        });
        $data           
            ->addRule('text:min=2','title')           
            ->validate();       
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
        $this->onDataValid(function($data) {
            $uuid = $data->get('uuid');
            $model = Model::Ads('ads');

            $exists = $model->where('title','=',$data['title'])->where('uuid','<>',$uuid)->exists();
            if ($exists == true) {
                $this->error('errors.exist');
                return;
            }

            $ad = $model->findById($uuid);
            $result = $ad->update($data->toArray());
               
            $this->setResponse($result,function() use($uuid) {                                
                $this
                    ->message('update')
                    ->field('uuid',$uuid);                         
            },'errors.update');
        });
        $data           
            ->addRule('text:min=2','title')                        
            ->validate();       
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
        $this->onDataValid(function($data) {
            $uuid = $data->get('uuid');
            $model = Model::Ads('ads')->findByid($uuid);

            $result = $model->delete();
            $this->setResponse($result,function() use($uuid) {            
                $this
                    ->message('delete')
                    ->field('uuid',$uuid);  
            },'errors.delete');
        }); 
        $data->validate();
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
        $this->onDataValid(function($data) {
            $uuid = $data->get('uuid');
            $code = $data->get('code',null);
            $model = Model::Ads('ads')->findById($uuid);
            if (\is_object($model) == false) {
                $this->error('errors.id');
                return;
            }
 
            $result = $model->update(['code' => $code]);
               
            $this->setResponse($result,function() use($model) {                                
                $this
                    ->message('update')
                    ->field('uuid',$model->uuid);                         
            },'errors.update');
        });
        $data           
            ->addRule('text:min=2','uuid')                        
            ->validate();       
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
        $this->onDataValid(function($data) {
            $uuid = $data->get('uuid');
            $linkUrl = $data->get('link_url',null);
            $model = Model::Ads('ads')->findById($uuid);
            if (\is_object($model) == false) {
                $this->error('errors.id');
                return;
            }
 
            $result = $model->update(['link_url' => $linkUrl]);
               
            $this->setResponse($result,function() use($model) {                                
                $this
                    ->message('update')
                    ->field('uuid',$model->uuid);                         
            },'errors.update');
        });
        $data           
            ->addRule('text:min=2','uuid')                        
            ->validate();       
    }
}
