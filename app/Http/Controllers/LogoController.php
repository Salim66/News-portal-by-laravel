<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;


class LogoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        // check ajax request by yjra datatable
        if ( request()->ajax() ) {

            return datatables()->of( Logo::with( 'languages' )->where( 'trash', false )->latest()->get() )->addColumn( 'action', function ( $data ) {
                $output = '<a title="Edit" edit_id="' . $data['id'] . '" href="#" class="btn btn-sm btn-warning edit_logo_data"><i class="fas fa-edit text-white"></i></a>';
                return $output;
            } )->rawColumns( ['action'] )->make( true );

        }

        return view( 'backend.logos.index' );

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
            'logo' => 'required',
        ] );

        //Logo image
        $image_unique_name = '';
        if ( $request->hasFile( 'logo' ) ) {
            $image = $request->file( 'logo' );
            $image_unique_name = md5( time() . rand() ) . '.' . $image->getClientOriginalExtension();
            // get extension
            $extension = pathinfo( $image_unique_name, PATHINFO_EXTENSION );
            $valid_extesion = ['jpg', 'jpeg', 'png', 'gif'];
            if ( in_array( $extension, $valid_extesion ) ) {
                $image->move( public_path( 'media/logos/' ), $image_unique_name );
            } else {
                return response()->json( [
                    'error' => 'Invalid file format! ',
                ] );
            }
        }

        Logo::create( [
            'language_id' => $request->language_id,
            'logo'        => $image_unique_name,
        ] );

        return response()->json( [
            'success' => 'Data added successfully ): ',
        ] );

    }

    /**
     * Display the specified resource.
     *
     * @param  \Logo  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        $data = Logo::findOrFail( $id );
        return response()->json( $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Logo  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $data = Logo::findOrFail( $id );
        return response()->json( $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Logo  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function updateLogo( Request $request ) {

        //get all data
        $id = $request->id;
        $language_id = $request->language_id;

        // check language has or not
        $data = Logo::findOrFail( $id );

        //Logo Image
        $image_unique_name = '';
        if ( $request->hasFile( 'logo' ) ) {
            $image = $request->file( 'logo' );
            $image_unique_name = md5( time() . rand() ) . '.' . $image->getClientOriginalExtension();
            $extension = pathinfo( $image_unique_name, PATHINFO_EXTENSION );
            $valid_extension = ['jpg', 'jpeg', 'png', 'gif'];
            if ( in_array( $extension, $valid_extension ) ) {
                $image->move( public_path( 'media/logos/' ), $image_unique_name );
            } else {
                return response()->json( [
                    'error' => 'Invalid file format! ',
                ] );
            }
            if ( file_exists( 'media/logos/' . $data->logo ) && !empty( $data->logo ) ) {
                unlink( 'media/logos/' . $data->logo );
            }
        } else {
            $image_unique_name = $data->logo;
        }

        if ( $data != NULL ) {
            $data->language_id = $language_id;
            $data->logo = $image_unique_name;
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
    public function updateLogoStatus( $id, $val ) {
        $data = Logo::findOrFail( $id );

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
    public function listLogoTrash() {

        // check ajax request by yjra datatable
        if ( request()->ajax() ) {

            return datatables()->of( Logo::with( 'languages' )->where( 'trash', true )->latest()->get() )->addColumn( 'action', function ( $data ) {
                $output = '<form style="display: inline;" action="#" method="POST" id="logo_delete_form"><input type="hidden" name="id" id="delete_logo" value="' . $data['id'] . '"><button type="submit" class="btn btn-sm ml-1 btn-danger" ><i class="fa fa-trash"></i></button></form>';
                return $output;
            } )->rawColumns( ['action'] )->make( true );

        }

        return view( 'backend.logos.trash' );

    }

    /**
     *
     *   Trash update method
     */
    public function updateLogoTrash( $id, $val ) {
        $data = Logo::findOrFail( $id );

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
        $data = Logo::findOrFail( $delete_id );
        // return $data;

        try {

            if ( $data ) {

                if ( file_exists( 'media/logos/' . $data->logo ) || !empty( $data->logo ) ) {
                    unlink( 'media/logos/' . $data->logo );
                }

                $data->delete();
                return 'Data deleted successfully :) ';

            }

        } catch ( \Throwable$th ) {
            return 'Data deleted failed badly!';
        }

    }

}
