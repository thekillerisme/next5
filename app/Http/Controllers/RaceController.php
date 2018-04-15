<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Resources\RaceCollection;
use App\Http\Resources\Race as RaceResource;
use App\Race;

class RaceController extends Controller
{
	/**
	 * Return application main page
	 * @param  Request $request 
	 * @return [HTML]           
	 */
	public function home(Request $request)
	{
		return response()->view('home');
	}

	/**
	 * Return the list of the next 5 races
	 * @param  Request $request 
	 * @return [JSON]           
	 */
	public function next5(Request $request)
	{
		//	Take the next 5 races that are about to close, but don't take any race that is about to close in the next 1 second
		//	(useless)
		return new RaceCollection(
			Race::with('meeting')
				->where('close_time', '>', Carbon::now()->addSecond()->format('Y-m-d H:i:s'))
				->orderBy('close_time', 'asc')
				->take(5)->get()
		);
	}

	/**
	 * Return details on a race but only if the race is not closed
	 * @param  [Integer] $id Race id
	 * @return [JSON]    
	 */
	public function show($id)
	{	
		$race = Race::with(['meeting', 'competitors' => function ($query) {
			    $query->orderBy('position', 'asc');
			}])
			->where('close_time', '>', Carbon::now()->format('Y-m-d H:i:s'))
			->find($id);


		return $race ? new RaceResource($race) : response('', 204);
	}
}
