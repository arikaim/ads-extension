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

use Arikaim\Core\Db\Traits\Uuid;
use Arikaim\Core\Db\Traits\Find;
use Arikaim\Core\Db\Traits\Status;
use Arikaim\Core\Db\Traits\Slug;

/**
 * Ads model class
 */
class Ads extends Model  
{
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
     * Find ad
     *
     * @param string $slug
     * @return Model|null
     */
    public function findAd(string $slug)
    {
        $model = $this->findBySlug($slug);
        if (\is_object($model) == false) {
            // find by id or uuid
            $model = $this->findById($slug);
        }
     
        return ($model === false) ? null : $model;      
    }

    /**
     * Return true if ad exist
     *
     * @param string $title
     * @return boolean
     */
    public function hasAd(string $title): bool 
    {
        return ($this->findAd($title) == null) ? false : true;
    }

    /**
     * Create ad
     *
     * @param string $title
     * @param string $code
     * @param string|null $description
     * @return Model|false
     */
    public function createAd(string $title, string $code, ?string $description = null)
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
     * @param string $slug
     * @return string|false
     */
    public function getCode(string $slug)
    {
        $model = $this->findAd($slug);
        if (\is_object($model) == false) {
            return false;
        }
        if ($model->status != 1) {
            // disabled
            return false;
        }
     
        return \trim($model->code);
    }
}
