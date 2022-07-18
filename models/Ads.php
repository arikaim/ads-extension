<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Ads\Models;

use Illuminate\Database\Eloquent\Model;

use Arikaim\Core\Http\Url;
use Arikaim\Core\Db\Traits\Uuid;
use Arikaim\Core\Db\Traits\Find;
use Arikaim\Core\Db\Traits\Status;
use Arikaim\Core\Db\Traits\Slug;

/**
 * Ads model class
 */
class Ads extends Model  
{
    const JS_TYPE      = 'js';
    const BANNER_TYPE  = 'banner';

    use Uuid,    
        Status,   
        Slug,
        Find;
    
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'ads';

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'slug',
        'title',
        'type',
        'link_url',
        'description',
        'status'      
    ];
    
    /**
     * Disable timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get banner link url
     *
     * @return string
     */
    public function getLinkUrl(): string
    {
        return Url::getUrl('/api/ads/link/' . $this->uuid,true);
    }

    /**
     * Return true if ads is banner
     *
     * @return boolean
     */
    public function isBanner(): bool
    {
        return ($this->type == Self::BANNER_TYPE);
    }

    /**
     * Find ad
     *
     * @param string $slug
     * @return Model|null
     */
    public function findAd(?string $slug)
    {
        if (empty($slug) == true) {
            return null;
        }

        $model = $this->findBySlug($slug);
        return ($model == null) ? $this->findById($slug) : $model;     
    }

    /**
     * Return true if ad exist
     *
     * @param string $title
     * @return boolean
     */
    public function hasAd(string $title): bool 
    {
        return ($this->findAd($title) != null);
    }

    /**
     * Create ad
     *
     * @param string $title
     * @param string|null $code
     * @param string|null $description
     * @return Model|false
     */
    public function createAd(string $title, ?string $code = null, ?string $description = null)
    {      
        if ($this->hasAd($title) == true) {
            return false;
        }

        return $this->create([
            'title'       => $title, 
            'code'        => $code,
            'description' => $description
        ]);      
    }

    /**
     * Get ad code
     *
     * @param string|null $slug
     * @return string|null
     */
    public function getCode(?string $slug = null): ?string
    {
        $model = (empty($slug) == false) ? $this->findAd($slug) : $this;
        if ($model == null) {
            return null;
        }
        if ($model->status != 1) {
            // disabled
            return null;
        }
     
        return \trim($model->code);
    }
}
