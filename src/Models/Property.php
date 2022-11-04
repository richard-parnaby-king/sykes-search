<?php

namespace RichardPK\Search\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Property extends Model
{
    protected $primaryKey = '__pk';
    
    /**
     * Get the location for this booking.
     * @return Location
     */
    public function location() {
        return $this->hasOne(Location::class, '__pk', '_fk_location');
    }
    
    /**
     * Get related Bookings for this property.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings() {
        return $this->hasMany(Booking::class, '_fk_property','__pk');
    }
    
    /**
     * Build a db query to filter properties by supplied filters.
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function findByQuery(Request $request) {
        $properties = self::with(['location','bookings'])
            ->join('locations', 'locations.__pk', '=', 'properties._fk_location');
            
        $inputs = $request->input();
        $inputs = array_filter($inputs, function($value){ return !is_null($value); });
        
        //Filters
        if(count($inputs)) {
            //Filter by location with exact and partial naming matches.
            if(!is_null($location = $request->input('location'))) {
                $properties->where('location_name', 'like', '%' . $location . '%');
            }
            //Near the beach
            if(!is_null($near_beach = $request->input('near_beach'))) {
                $properties->where('near_beach', $near_beach);
            }
            //Accepts pets
            if(!is_null($accepts_pets = $request->input('accepts_pets'))) {
                $properties->where('accepts_pets', $accepts_pets);
            }
            //Minimum sleeps
            if(!is_null($sleeps = $request->input('sleeps'))) {
                $properties->where('sleeps', '>=', $sleeps);
            }
            //Minimum beds
            if(!is_null($beds = $request->input('beds'))) {
                $properties->where('beds', '>=', $beds);
            }
            
            //Filter by availability start/end date.
            $start = $request->input('start_date');
            $end = $request->input('end_date');
            if( !is_null($start) || !is_null($end) ) {
                //Join bookings table and group by properties.__pk so we don't get duplicate
                // property data for each booking.
                $properties->leftJoin('bookings', 'properties.__pk', '=', 'bookings._fk_property')
                    ->groupBy('properties.__pk');
                
                //By default, select is *. This will also include bookings.* data.
                // We don't want that. Just select the properties.* data.
                $properties->select(['properties.*']);
                
                //Both start/end date specified.
                if(!is_null($start) && !is_null($end)) {
                    
                    $properties->where(function($query) use ($start, $end) {
                        $query->whereNull('start_date')
                            ->orWhere(function($subquery) use ($start, $end) {
                                $subquery->whereNotBetween('start_date', [$start, $end])
                                         ->whereNotBetween('end_date', [$start, $end]);
                            });
                    });
                    
                }
                //Select where the start/end date does not contain the specified $start/$end date.
                else {
                    //null coalescing operator. If $start is null, use $end, otherwise use $start.
                    $date = $start ?? $end;
                    
                    $properties->where(function($query) use ($date){
                        $query->whereNull('start_date')
                            ->orWhere(function($subquery) use ($date) {
                                $subquery->whereNotBetween(DB::raw("'" . $date . "'"), [DB::raw('`start_date`'), DB::raw('`end_date`')]);
                            });
                    });
                    
                }
            }
        }
        
        return $properties;
    }
}
