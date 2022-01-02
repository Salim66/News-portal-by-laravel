<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        // check ajax request by yjra datatable
        if ( request()->ajax() ) {

            return datatables()->of( Footer::with('languages')->where( 'trash', false )->latest()->get() )->addColumn( 'action', function ( $data ) {
                $output = '<a title="Edit" edit_id="' . $data['id'] . '" href="#" class="btn btn-sm btn-warning edit_footer_data"><i class="fas fa-user-edit text-white"></i></a>';
                return $output;
            } )->rawColumns( ['action'] )->make( true );

        }

        return view( 'backend.footers.index' );

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'view.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {

        $this->validate( $request, [
            'language_id' => 'required',
            'copyright_text'        => 'required',
            'footer_text'        => 'required',
        ] );


        Footer::create( [
            'language_id' => $request->language_id,
            'copyright_text'        => $request->copyright_text,
            'footer_text' => $request->footer_text,
        ] );

        return response()->json( [
            'success' => 'Data added successfully ): ',
        ] );

    }

    /**
     * Display the specified resource.
     *
     * @param  \Footer  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        $data = Footer::findOrFail( $id );
        return response()->json( $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Footer  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $data = Footer::findOrFail( $id );
        return response()->json( $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Footer  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function updateFooter( Request $request ) {

        //get all data
        $id = $request->id;
        $language_id = $request->language_id;
        $copyright_text = $request->copyright_text;
        $footer_text = $request->footer_text;

        // check footer has or not
        $data = Footer::findOrFail( $id );

        if ( $data != NULL ) {
            $data->language_id = $language_id;
            $data->copyright_text = $copyright_text;
            $data->footer_text = $footer_text;
            $data->update();

            return response()->json( [
                'success' => 'Data updated successfully ): ',
            ] );
        } else {
            return response()->json( [
                'error' => 'Data not found!',
            ] );
        }

    }


    /**
     *
     *   Status update method
     */
    public function updateFooterStatus( $id, $val ) {
        $data = Footer::findOrFail( $id );

        if ( $val == 1 ) {
            $data->status = false;
            $data->update();
            return 'Data Inactive Succcessfully ): ';
        } else {
            $data->status = true;
            $data->update();
            return 'Data Active Succcessfully ): ';
        }

    }


    /**
     *
     *   Trash list page method
     */
    public function listFooterTrash() {

        // check ajax request by yjra datatable
        if ( request()->ajax() ) {

            return datatables()->of( Footer::with('languages')->where( 'trash', true )->latest()->get() )->addColumn( 'action', function ( $data ) {
                $output = '<form style="display: inline;" action="#" method="POST" id="footer_delete_form"><input type="hidden" name="id" id="delete_footer" value="' . $data['id'] . '"><button type="submit" class="btn btn-sm ml-1 btn-danger" ><i class="fa fa-trash"></i></button></form>';
                return $output;
            } )->rawColumns( ['action'] )->make( true );

        }

        return view( 'backend.footers.trash' );

    }


    /**
     *
     *   Trash update method
     */
    public function updateFooterTrash( $id, $val ) {
        $data = Footer::findOrFail( $id );

        if ( $val == 1 ) {
            $data->trash = false;
            $data->update();
            return 'Data Remove Trash Succcessfully ): ';
        } else {
            $data->trash = true;
            $data->update();
            return 'Data Trash Succcessfully ): ';
        }

    }

    /**
     * Data Delete
     */
    public function deleteByAjax( Request $request ) {

        $delete_id = $request->id;
        $data = Footer::findOrFail( $delete_id );
        // return $data;

        try {

            if ( $data ) {

                $data->delete();
                return 'Data deleted successfully :) ';

            }

        } catch ( \Throwable$th ) {
            return 'Data deleted failed badly!';
        }

    }

}
