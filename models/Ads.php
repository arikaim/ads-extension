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
    protected $table = "ads";

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
     * Create ad
     *
     * @param string $title
     * @param string $code
     * @param string $description
     * @return Model|false
     */
    public function createAd($title, $code, $description = null)
    {      
        if (empty($title) == true) {
            return false;
        }

        if ($this->where('title','=',$title)->count() > 0) {
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
    public function getCode($slug)
    {
        $model = $this->findBySlug($slug);
        if (is_object($model) == false) {
            $model = $this->findByColumn($slug,'title');
        }
        if (is_object($model) == false) {
            return false;
        }
        $code = ($model->status != 1) ? null : trim($model->code);

        return (empty($code) == true) ? false : $code;
    }
}
