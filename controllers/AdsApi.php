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

use Arikaim\Core\Controllers\ApiController;
use Arikaim\Core\Db\Model;
use Arikaim\Core\Http\Url;

/**
 * Ads api controller
*/
class AdsApi extends ApiController 
{
    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {       
    }

    /**
     *  Open banner ad link
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function openLink($request, $response, $data) 
    {       
        $code = $data->get('code'); 
        $model = Model::Ads('ads')->findAd($code);
        if ($model == null) {
            $this->error('Not valid ads id');
            return false; 
        }
         
        if (Url::isValid($model->link_url) == false) {
            $this->error('Not valid ads link url.');
            return false; 
        }

        $model->increment('views');

        return $response
                    ->withHeader('Location',$model->link_url)
                    ->withStatus(307);
    }
}
