<?php

namespace App\Http\Controllers;

use App\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ClassroomController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function index() {
		$search_term = request()->input( 'search' );
//		$limit       = 5;
		$classrooms = null;
//		$data = array( 'data' => null, 'search' => '' );
		if ( $search_term ) { // deprecated since now use frontend to search only, but still retain for future reference
			$classrooms = Classroom::orwhere( 'class_label', 'LIKE', "%$search_term%" )
			                       ->orwhere( 'campus', 'LIKE', "%$search_term%" )->orderBy( 'id', 'asc' )->get();

			$classrooms = $this->transformCollection( $classrooms, $search_term );
		} else {
			$classrooms = Classroom::orderBy( 'id', 'asc' )->get();
			$classrooms = $this->transformCollection( $classrooms );
		}

		return Response::json( [
			$classrooms
		], 200 );
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
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function create() {
		return Response::json( [
			"error" => "This api is not allowed!"
		], 403 );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$data = $request->validate( [
			"class_label" => "required|min:5",
			"campus"      => "required",
			"isAud"       => "required|boolean",
		] );
		Classroom::create( $data );

		return Response::json( [
			"message" => "Successfully save!"
		], 200 );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Classroom $classroom
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function show( Classroom $classroom ) {
		return Response::json( [ //invalid id error handling had been done in Exceptions\Handler
			'data' => $classroom
		], 200 );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\Classroom $classroom
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function edit( Classroom $classroom ) {
		$form_array                = array();
		$form_array["id"]          = $classroom->id;
		$form_array["class_label"] = $classroom->class_label;
		$form_array["campus"]      = $classroom->campus;
		$form_array["isAud"]       = $classroom->isAud;

		// more for qc config;


		return Response::json( [
			"form" => $form_array
		], 200 );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Classroom $classroom
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function update( Request $request, Classroom $classroom ) {
		$data = $request->validate( [
			"class_label" => "required|min:5",
			"campus"      => "required",
			"isAud"       => "required|boolean",
		] );
		$classroom->update( $data );

		return Response::json( [
			"message" => "Successfully updated!"
		], 200 );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Classroom $classroom
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy( Classroom $classroom ) {
		$classroom->delete();

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
