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
        if (\is_object($model) == false) {
            $this->error('Not valid ads id');
            return $this->getResponse(); 
        }
         
        if (Url::isValid($model->link_url) == false) {
            $this->error('Not valid ads link url.');
            return $this->getResponse(); 
        }

        $model->increment('views');

        return $this->withRedirect($response,$model->link_url);
    }
}
