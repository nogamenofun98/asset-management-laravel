<?php

namespace App\Http\Controllers;

use App\Projector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProjectorController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index() {
		$search_term = request()->input( 'search' );
//		$limit       = 5;
		$projectors = null;
//		$data = array( 'data' => null, 'search' => '' );
		if ( $search_term ) { // deprecated since now use frontend to search only, but still retain for future reference
			$projectors = Projector::orwhere( 'projector_label', 'LIKE', "%$search_term%" )
			                       ->orwhere( 'model', 'LIKE', "%$search_term%" )
			                       ->orwhere( 'serial_number', 'LIKE', "%$search_term%" )
			                       ->orwhere( 'lamp_hour', 'LIKE', "%$search_term%" )->orderBy( 'id', 'asc' )->get();
//			                       ->paginate( $limit ); // remove because frontend is use virtual scroll, so no need paginate d
//			$projectors = $projectors->toArray();
//			dump($projectors);
//			$data = array_merge( $projectors,
//				[ 'search' => $search_term ]
//			);
//			$data['data']   = $projectors;
//			$data['search'] = $search_term;
			$projectors = $this->transformCollection( $projectors, $search_term );
//			$projectors->put('search', $search_term);

		} else {
			$projectors = Projector::paginate( 5 );
//			$projectors = Projector::orderBy('id', 'asc')->get();
//			$projectors = $this->transformCollection($projectors);
//			$data['data'] = $projectors;
		}

		return Response::json( [
			$projectors //alrdy in json format
		], 200 );


//	    return Response::json([
//		    'data' => $projectors
//	    ], 200);
	}

	private function transformCollection( $array, $search = null ) {
		$newArray = $array->toArray();
		if ( $search ) {
			return [
				'data'   => array_map( [ $this, 'transform' ], $newArray ),
				'search' => $search,
			];
		}

		return [
			'data' => array_map( [ $this, 'transform' ], $newArray ),
		];
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function create() {
		//does not require, because form is handle by frontend
		//redirect to 404
		return Response::json( [
			"error" => "This api is not allowed!"
		], 403 );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store( Request $request ) {
		/*$table->string("projector_label");
			$table->string("model");
			$table->string("serial_number");
			$table->unsignedInteger("lamp_hour");*/

		$data = $request->validate( [
			"projector_label" => "required|min:5",
			"model"           => "required",
			"serial_number"   => "required",
			"lamp_hour"       => "required|numeric",
		] );
		Projector::create( $data );
		//if validation has error, will be handle by laravel & generated json error, but first, need to set as ajax request
		/* Ex:
		 * {
	"message": "The given data was invalid.",
	"errors": {
		"projector_label": [
			"The projector label must be at least 5 characters."
		],
		"serial_number": [
			"The serial number field is required."
		]
	}
}*/

		return Response::json( [
			"message" => "Successfully save!"
		], 200 );

	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Projector $projector
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show( Projector $projector ) {
		return Response::json( [ //invalid id error handling had been done in Exceptions\Handler
			'data' => $projector
		], 200 );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\Projector $projector
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function edit( Projector $projector ) {
		//get all data and return in json for display in edit form in frontend
		/*$table->string("projector_label");
			$table->string("model");
			$table->string("serial_number");
			$table->unsignedInteger("lamp_hour");*/
		$form_array                    = array();
		$form_array["id"]              = $projector->id;
		$form_array["projector_label"] = $projector->projector_label;
		$form_array["model"]           = $projector->model;
		$form_array["serial_number"]   = $projector->serial_number;
		$form_array["lamp_hour"]       = $projector->lamp_hour;

		return Response::json( [
			"form" => $form_array
		], 200 );


	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Projector $projector
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function update( Request $request, Projector $projector ) {
//    	dd($request->all());
		$data = $request->validate( [
			"projector_label" => "required|min:5",
			"model"           => "required",
			"serial_number"   => "required",
			"lamp_hour"       => "required|numeric",
		] );
		$projector->update( $data );

		return Response::json( [
			"message" => "Successfully updated!"
		], 200 );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Projector $projector
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy( Projector $projector ) {
		$projector->delete();

		return Response::json( [
			"message" => "Successfully deleted!"
		], 200 );
	}

	private function transform( $array ) {
		return [
			'id'              => $array['id'],
			'projector_label' => $array['projector_label'],
			'serial_number'   => $array['serial_number'],
			'model'           => $array['model']
		];
	}
}
