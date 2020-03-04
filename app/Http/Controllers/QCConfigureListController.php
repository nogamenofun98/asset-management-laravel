<?php

namespace App\Http\Controllers;

use App\QC_Configure_List;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class QCConfigureListController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function index() {
		$search_term = request()->input( 'search' );
		$qc_config   = null;
		if ( $search_term ) { // deprecated since now use frontend to search only, but still retain for future reference
			$qc_config = QC_Configure_List::orwhere( 'config_name', 'LIKE', "%$search_term%" )->orderBy( 'id', 'asc' )->get();
		} else {
			$qc_config = QC_Configure_List::orderBy( 'id', 'asc' )->get();
		}

		return Response::json( [
			$qc_config //alrdy in json format
		], 200 );

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
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
			"config_name" => "required",
			"config"      => "required|json",
		] );
		QC_Configure_List::create( $data );

		return Response::json( [
			"message" => "Successfully save!"
		], 200 );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\QC_Configure_List $qC_Configure_List
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show( $qC_Configure_List ) { // doesnt use magic QC_Configure_List because it fail to find out the model somehow, so fall back to old school method
//		dd('asd');
		$qc_config_obj = QC_Configure_List::findOrFail( $qC_Configure_List );

		return Response::json( [ //invalid id error handling had been done in Exceptions\Handler
			'data' => $qc_config_obj
		], 200 );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\QC_Configure_List $qC_Configure_List
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function edit( $qC_Configure_List ) {
		$qc_config_obj             = QC_Configure_List::findOrFail( $qC_Configure_List );
		$form_array                = array();
		$form_array["id"]          = $qc_config_obj->id;
		$form_array["config_name"] = $qc_config_obj->config_name;
		$form_array["config"]      = $qc_config_obj->config;

		return Response::json( [
			"form" => $form_array
		], 200 );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\QC_Configure_List $qC_Configure_List
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function update( Request $request, $qC_Configure_List ) {
		$data          = $request->validate( [
			"config_name" => "required",
			"config"      => "required|json",
		] );
		$qc_config_obj = QC_Configure_List::findOrFail( $qC_Configure_List );
		$qc_config_obj->update( $data );

		return Response::json( [
			"message" => "Successfully updated!"
		], 200 );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\QC_Configure_List $qC_Configure_List
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy( $qC_Configure_List ) {
		$qc_config_obj = QC_Configure_List::findOrFail( $qC_Configure_List );
		$qc_config_obj->delete();

		return Response::json( [
			"message" => "Successfully deleted!"
		], 200 );
	}
}
