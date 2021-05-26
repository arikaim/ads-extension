<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Ads\Models\Schema;

use Arikaim\Core\Db\Schema;

/**
 * Ads db table
 */
class AdsSchema extends Schema  
{    
    /**
     * Table name
     *
     * @var string
     */
    protected $tableName = "ads";

    /**
     * Create table
     *
     * @param \Arikaim\Core\Db\TableBlueprint $table
     * @return void
     */
    public function create($table) 
    {            
        // columns    
        $table->id();      
        $table->prototype('uuid');   
        $table->status();         
        $table->userId();
        $table->slug();
        $table->string('type')->nullable(true); 
        $table->string('title')->nullable(true); 
        $table->string('link_url')->nullable(true); 
        $table->text('description')->nullable(true);      
        $table->text('code')->nullable(true); 
        $table->integer('views')->nullable(false)->default(0);  
        // index       
        $table->unique(['title']);   
    }

    /**
     * Update table
     *
     * @param \Arikaim\Core\Db\TableBlueprint $table
     * @return void
     */
    public function update($table) 
    {              
        if ($this->hasColumn('type') == false) {
            $table->string('type')->nullable(true);
        }
        if ($this->hasColumn('link_url') == false) {
            $table->string('link_url')->nullable(true);
        }
    }

    /**
     * Insert or update rows in table
     *
     * @param Seed $seed
     * @return void
     */
    public function seeds($seed)
    {       
    }
}
