<?php

namespace RichardPK\Search\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RichardPK\Search\Models\Property;


class SearchController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return String
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function get(Request $request)
    {
        //Validate all inputs. All inputs are optional.
        $request->validate([
            'location' => ['nullable', 'string', 'max:255'],
            'near_beach' => ['nullable', 'boolean'],
            'accepts_pets' => ['nullable', 'boolean'],
            'sleeps' => ['nullable', 'integer', 'min:1'],
            'beds' => ['nullable', 'integer', 'min:1'],
            #'start_date' => ['nullable', 'date', 'after_or_equal:today'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
        ]);
        
        
        //Default return values.
        $params = [
            'show_results' => false,
            'count' => null,
            'results' => [],
            'selectedPerPage' => 10,
        ];
        
        //If form submitted, get Properties and update return values.
        if(count(array_filter($request->input(), function($value){ return !is_null($value); }))) {
            //Get properties.
            $propertyModel = new Property();
            //25 (default) results per page.
            $perPage = $request->input('perpage', $params['selectedPerPage']);
            $properties = $propertyModel->findByQuery($request)->paginate($perPage)->withQueryString();
            
            $params['show_results'] = true;
            $params['count'] = $properties->total();
            $params['selectedPerPage'] = $perPage;
            $params['results'] = $properties;
        }
        
        return view('search::form', $params);
    }
}
