<?php

namespace RichardPK\Search\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = '__pk';
    
    /**
     * Get the property for this booking.
     * @return Property
     */
    public function property() {
        return $this->hasOne(Property::class, '_fk_property', '__pk');
    }
}
