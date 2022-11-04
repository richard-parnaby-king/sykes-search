<?php

namespace RichardPK\Search\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $primaryKey = '__pk';
    
    /**
     * Get related properties for this Location.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties() {
        return $this->hasMany(Property::class, '_fk_location','__pk');
    }
}
