<?php

namespace App\Http\Controllers;

use App\Models\Favicon;
use Illuminate\Http\Request;

class FaviconContorller extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        // check ajax request by yjra datatable
        if ( request()->ajax() ) {

            return datatables()->of( Favicon::with( 'languages' )->where( 'trash', false )->latest()->get() )->addColumn( 'action', function ( $data ) {
                $output = '<a title="Edit" edit_id="' . $data['id'] . '" href="#" class="btn btn-sm btn-warning edit_favicon_data"><i class="fas fa-edit text-white"></i></a>';
                return $output;
            } )->rawColumns( ['action'] )->make( true );

        }

        return view( 'backend.favicons.index' );

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
            'favicon' => 'required',
        ] );

        //Favicon image
        $image_unique_name = '';
        if ( $request->hasFile( 'favicon' ) ) {
            $image = $request->file( 'favicon' );
            $image_unique_name = md5( time() . rand() ) . '.' . $image->getClientOriginalExtension();
            // get extension
            $extension = pathinfo( $image_unique_name, PATHINFO_EXTENSION );
            $valid_extesion = ['jpg', 'jpeg', 'png', 'gif'];
            if ( in_array( $extension, $valid_extesion ) ) {
                $image->move( public_path( 'media/favicons/' ), $image_unique_name );
            } else {
                return response()->json( [
                    'error' => 'Invalid file format! ',
                ] );
            }
        }

        Favicon::create( [
            'language_id' => $request->language_id,
            'favicon'        => $image_unique_name,
        ] );

        return response()->json( [
            'success' => 'Data added successfully ): ',
        ] );

    }

    /**
     * Display the specified resource.
     *
     * @param  \Favicon  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        $data = Favicon::findOrFail( $id );
        return response()->json( $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Favicon  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $data = Favicon::findOrFail( $id );
        return response()->json( $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Favicon  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function updateFavicon( Request $request ) {

        //get all data
        $id = $request->id;
        $language_id = $request->language_id;

        // check language has or not
        $data = Favicon::findOrFail( $id );

        //Favicon Image
        $image_unique_name = '';
        if ( $request->hasFile( 'favicon' ) ) {
            $image = $request->file( 'favicon' );
            $image_unique_name = md5( time() . rand() ) . '.' . $image->getClientOriginalExtension();
            $extension = pathinfo( $image_unique_name, PATHINFO_EXTENSION );
            $valid_extension = ['jpg', 'jpeg', 'png', 'gif'];
            if ( in_array( $extension, $valid_extension ) ) {
                $image->move( public_path( 'media/favicons/' ), $image_unique_name );
            } else {
                return response()->json( [
                    'error' => 'Invalid file format! ',
                ] );
            }
            if ( file_exists( 'media/favicons/' . $data->favicon ) && !empty( $data->favicon ) ) {
                unlink( 'media/favicons/' . $data->favicon );
            }
        } else {
            $image_unique_name = $data->favicon;
        }

        if ( $data != NULL ) {
            $data->language_id = $language_id;
            $data->favicon = $image_unique_name;
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
    public function updateFaviconStatus( $id, $val ) {
        $data = Favicon::findOrFail( $id );

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
    public function listFaviconTrash() {

        // check ajax request by yjra datatable
        if ( request()->ajax() ) {

            return datatables()->of( Favicon::with( 'languages' )->where( 'trash', true )->latest()->get() )->addColumn( 'action', function ( $data ) {
                $output = '<form style="display: inline;" action="#" method="POST" id="favicon_delete_form"><input type="hidden" name="id" id="delete_favicon" value="' . $data['id'] . '"><button type="submit" class="btn btn-sm ml-1 btn-danger" ><i class="fa fa-trash"></i></button></form>';
                return $output;
            } )->rawColumns( ['action'] )->make( true );

        }

        return view( 'backend.favicons.trash' );

    }

    /**
     *
     *   Trash update method
     */
    public function updateFaviconTrash( $id, $val ) {
        $data = Favicon::findOrFail( $id );

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
        $data = Favicon::findOrFail( $delete_id );
        // return $data;

        try {

            if ( $data ) {

                if ( file_exists( 'media/favicons/' . $data->favicon ) || !empty( $data->favicon ) ) {
                    unlink( 'media/favicons/' . $data->favicon );
                }

                $data->delete();
                return 'Data deleted successfully :) ';

            }

        } catch ( \Throwable$th ) {
            return 'Data deleted failed badly!';
        }

    }

}
