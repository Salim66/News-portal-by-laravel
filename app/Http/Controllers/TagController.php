<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        // check ajax request by yjra datatable
        if ( request()->ajax() ) {

            return datatables()->of( Tag::with('languages')->where( 'trash', false )->latest()->get() )->addColumn( 'action', function ( $data ) {
                $output = '<a title="Edit" edit_id="' . $data['id'] . '" href="#" class="btn btn-sm btn-warning edit_tag_data"><i class="fas fa-edit text-white"></i></a>';
                return $output;
            } )->rawColumns( ['action'] )->make( true );

        }

        return view( 'backend.tags.index' );

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
            'name'        => 'required',
        ] );


        Tag::create( [
            'language_id' => $request->language_id,
            'name'        => $request->name,
            'slug'        => $this->getSlug( $request->name )
        ] );

        return response()->json( [
            'success' => 'Data added successfully ): ',
        ] );

    }

    /**
     * Display the specified resource.
     *
     * @param  \Tag  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        $data = Tag::findOrFail( $id );
        return response()->json( $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Tag  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $data = Tag::findOrFail( $id );
        return response()->json( $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Tag  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function updateTag( Request $request ) {

        //get all data
        $id = $request->id;
        $language_id = $request->language_id;
        $name = $request->name;

        // check tag has or not
        $data = Tag::findOrFail( $id );

        if ( $data != NULL ) {
            $data->language_id = $language_id;
            $data->name = $name;
            $data->slug = $this->getSlug( $name );
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
    public function updateTagStatus( $id, $val ) {
        $data = Tag::findOrFail( $id );

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
    public function listTagTrash() {
        
        // check ajax request by yjra datatable
        if ( request()->ajax() ) {

            return datatables()->of( Tag::with('languages')->where( 'trash', true )->latest()->get() )->addColumn( 'action', function ( $data ) {
                $output = '<form style="display: inline;" action="#" method="POST" id="tag_delete_form"><input type="hidden" name="id" id="delete_tag" value="' . $data['id'] . '"><button type="submit" class="btn btn-sm ml-1 btn-danger" ><i class="fa fa-trash"></i></button></form>';
                return $output;
            } )->rawColumns( ['action'] )->make( true );

        }

        return view( 'backend.tags.trash' );

    }

    /**
     *
     *   Trash update method
     */
    public function updateTagTrash( $id, $val ) {
        $data = Tag::findOrFail( $id );

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
     * Tag Delete
     */
    public function deleteByAjax( Request $request ) {

        $delete_id = $request->id;
        $data = Tag::findOrFail( $delete_id );
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
