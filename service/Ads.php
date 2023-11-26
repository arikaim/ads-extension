<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Ads\Service;

use Psr\Container\ContainerInterface;

use Arikaim\Core\Db\Model;
use Arikaim\Core\Service\Service;
use Arikaim\Core\Service\ServiceInterface;

/**
 * Ads service class
*/
class Ads extends Service implements ServiceInterface
{
    /**
     * Init service
    */
    public function boot()
    {
        $this->setServiceName('ads');
        $this->includeServices(['image.library']);
    }

    /**
     * Gte ads code
     *
     * @param string|null $slug
     * @return string|null
     */
    public function getCode(?string $slug = null): ?string
    {
        return Model::Ads('ads')->getCode($slug);
    }

    /**
     * Get ad model
     *
     * @param string|null $slug
     * @return Model|null
     */
    public function getAd(?string $slug = null)
    {
        return Model::Ads('ads')->findAd($slug);
    }

    /**
     * Get banner image model
     *
     * @param string|null $slug
     * @return Model|null
     */
    public function getImage(?string $slug = null)
    {
        $model = Model::Ads('ads')->findAd($slug);
        if ($model == null) {
            return null;
        }
        if ($model->isBanner() == false) {
            return null;
        }

        return $this->getService('image.library')->getRelatedImage($model->id,'ads'); 
    }
}
