<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        // check ajax request by yjra datatable
        if ( request()->ajax() ) {

            return datatables()->of( Post::with( 'languages' )->with( 'user' )->where( 'trash', false )->latest()->get() )->addColumn( 'action', function ( $data ) {
                $output = '<a title="Preview" preview_id="' . $data['id'] . '" href="#" class="badge badge-pill preview_post d-inline-block mb-1"><i class="fas fa-eye text-white"></i></a>';
                $output .= '<a title="Edit" edit_id="' . $data['id'] . '" href="#" class="badge badge-pill bg-warning edit_post_data d-inline-block"><i class="fas fa-edit text-white"></i></a>';
                return $output;
            } )->rawColumns( ['action'] )->make( true );

        }

        return view( 'backend.posts.index' );

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

        //post image
        $image_unique_name = '';
        if ( $request->hasFile( 'post_image' ) ) {
            $image = $request->file( 'post_image' );
            $image_unique_name = md5( time() . rand() ) . '.' . $image->getClientOriginalExtension();
            // get extension
            $extension = pathinfo( $image_unique_name, PATHINFO_EXTENSION );
            $valid_extesion = ['jpg', 'jpeg', 'png', 'gif'];
            if ( in_array( $extension, $valid_extesion ) ) {
                $image->move( public_path( 'media/posts/' ), $image_unique_name );
            } else {
                return response()->json( [
                    'error' => 'Invalid file format! ',
                ] );
            }
        }

        //post gallery image
        $gallery_image_u_n = [];
        $gallery_image = $request->hasFile( 'post_gallery_image' );
        if ( $gallery_image != NULL ) {
            $g_image = $request->file( 'post_gallery_image' );
            foreach ( $g_image as $image ) {
                $gallery_image_unique_name = md5( time() . rand() ) . '.' . $image->getClientOriginalExtension();
                // get extension
                $extension = pathinfo( $gallery_image_unique_name, PATHINFO_EXTENSION );
                $valid_extesion = ['jpg', 'jpeg', 'png', 'gif'];
                if ( in_array( $extension, $valid_extesion ) ) {
                    array_push( $gallery_image_u_n, $gallery_image_unique_name );
                    $image->move( public_path( 'media/posts/' ), $gallery_image_unique_name );
                } else {
                    return response()->json( [
                        'error' => 'Invalid file format! ',
                    ] );
                }
            }
        }

        // featured information
        $post_featured = [
            'post_image'   => $image_unique_name,
            'post_gallery' => $gallery_image_u_n,
            'post_audio'   => $request->post_audio,
            'post_video'   => $this->getVideo( $request->post_video ),
        ];

        $data = Post::create( [
            'user_id'          => Auth::id(),
            'language_id'      => $request->language_id,
            'post_type'        => $request->post_type,
            'title'            => $request->title,
            'slug'             => $this->getSlug( $request->title ),
            'keyword_meta_tag' => $request->keyword_meta_tag,
            'description'      => $request->description,
            'featured'         => json_encode( $post_featured ),
        ] );

        $data->categories()->attach( $request->category_id );
        $data->tags()->attach( $request->tag_id );

        if ( $data == true ) {
            return response()->json( [
                'success' => 'Post added successfully ): ',
            ] );
        } else {
            return response()->json( [
                'error' => 'Sorry! do not added data! ',
            ] );
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \Post  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        $single_post = Post::findOrFail( $id );

        $post_fet = json_decode( $single_post->featured );

        return [
            'title'        => $single_post->title,
            'slug'         => $single_post->slug,
            'status'       => $single_post->status,
            'categories'   => $single_post->categories,
            'tags'         => $single_post->tags,
            'description'  => $single_post->description,
            'post_type'    => $single_post->post_type,
            'post_image'   => $post_fet->post_image,
            'post_gallery' => $post_fet->post_gallery,
            'post_audio'   => $post_fet->post_audio,
            'post_video'   => $post_fet->post_video,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Post  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $data = Post::findOrFail( $id );

        //All Category
        $all_category = Category::all();

        //Selected Category
        $selected_category = $data->categories;
        $select_cat = [];
        foreach ( $selected_category as $cat ) {
            array_push( $select_cat, $cat->id );
        }

        $cat_list = '';
        foreach ( $all_category as $category ) {
            if ( in_array( $category->id, $select_cat ) ) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $cat_list .= '<option value="' . $category->id . '" ' . $selected . '>' . $category->name . '</option>';
        }

        //All Tag
        $all_tag = Tag::all();

        //Selected tag
        $selected_tag = $data->tags;
        $select_tag = [];
        foreach ( $selected_tag as $tag ) {
            array_push( $select_tag, $tag->id );
        }

        $tag_list = '';
        foreach ( $all_tag as $tag ) {
            if ( in_array( $tag->id, $select_tag ) ) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $tag_list .= '<option value="' . $tag->id . '" ' . $selected . '>' . $tag->name . '</option>';
        }

        return [
            'title'            => $data->title,
            'keyword_meta_tag' => $data->keyword_meta_tag,
            'post_type'        => $data->post_type,
            'language_id'      => $data->language_id,
            'id'               => $data->id,
            'featured'         => $data->featured,
            'description'      => $data->description,
            'category_list'    => $cat_list,
            'tag_list'         => $tag_list,
        ];

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Post  ${{ modelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function updatePost( Request $request ) {
        // return $request->all();
        //find post data
        $data = Post::find( $request->id );
        if ( $data != null ) {

            $feature_data = json_decode( $data->featured );

            //post Image
            $image_unique_name = '';
            if ( $request->hasFile( 'post_image' ) ) {
                $image = $request->file( 'post_image' );
                $image_unique_name = md5( time() . rand() ) . '.' . $image->getClientOriginalExtension();
                $extension = pathinfo( $image_unique_name, PATHINFO_EXTENSION );
                $valid_extension = ['jpg', 'jpeg', 'png', 'gif'];
                if ( in_array( $extension, $valid_extension ) ) {
                    $image->move( public_path( 'media/posts/' ), $image_unique_name );
                } else {
                    return response()->json( [
                        'error' => 'Invalid file format! ',
                    ] );
                }
                if ( file_exists( 'media/posts/' . $feature_data->post_image ) && !empty( $feature_data->post_image ) ) {
                    unlink( 'media/posts/' . $feature_data->post_image );
                }
            } else {
                $image_unique_name = $feature_data->post_image;
            }

            //post gallery
            $gallery_unique_name_u = [];
            if ( $request->hasFile( 'post_gallery_image' ) ) {
                $images = $request->file( 'post_gallery_image' );
                foreach ( $images as $image ) {
                    $gallery_unique_name = md5( time() . rand() ) . '.' . $image->getClientOriginalExtension();
                    $extension = pathinfo( $gallery_unique_name, PATHINFO_EXTENSION );
                    $valid_extension = ['jpg', 'jpeg', 'png', 'gif'];
                    if ( in_array( $extension, $valid_extension ) ) {
                        array_push( $gallery_unique_name_u, $gallery_unique_name );
                        $image->move( public_path( 'media/posts/' ), $gallery_unique_name );
                    } else {
                        return response()->json( [
                            'error' => 'Invalid file format! ',
                        ] );
                    }
                    foreach ( $feature_data->post_gallery as $gallery ) {
                        if ( file_exists( 'media/posts/' . $gallery ) && !empty( $gallery ) ) {
                            unlink( 'media/posts/' . $gallery );
                        }
                    }
                }
            } else {
                $gallery_unique_name_u = $feature_data->post_gallery;
            }

            $post_featured = [
                'post_image'   => $image_unique_name,
                'post_gallery' => $gallery_unique_name_u,
                'post_audio'   => $request->post_audio,
                'post_video'   => $this->getUpdateVideo( $request->post_video, $feature_data ),
            ];

            $data->user_id = Auth::user()->id;
            $data->language_id = $request->language_id;
            $data->post_type = $request->post_type;
            $data->title = $request->title;
            $data->slug = $this->getSlug( $request->title );
            $data->keyword_meta_tag = $request->keyword_meta_tag;
            $data->description = $request->description;
            $data->featured = $post_featured;
            $data->update();

            $data->categories()->detach();
            $data->categories()->attach( $request->category_id );

            $data->tags()->detach();
            $data->tags()->attach( $request->tag_id );

            return response()->json( [
                'success' => 'Post updated successfully ): ',
            ] );

        } else {
            return response()->json( [
                'error' => 'Post data not found! ',
            ] );
        }

    }

    /**
     *
     *   Status update method
     */
    public function updatePostStatus( $id, $val ) {
        $data = Post::findOrFail( $id );

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
    public function listPostTrash() {

        // check ajax request by yjra datatable
        if ( request()->ajax() ) {

            return datatables()->of( Post::with( 'languages' )->where( 'trash', true )->latest()->get() )->addColumn( 'action', function ( $data ) {
                $output = '<form style="display: inline;" action="#" method="POST" id="post_delete_form"><input type="hidden" name="id" id="delete_post" value="' . $data['id'] . '"><button type="submit" class="btn btn-sm ml-1 btn-danger" ><i class="fa fa-trash"></i></button></form>';
                return $output;
            } )->rawColumns( ['action'] )->make( true );

        }

        return view( 'backend.posts.trash' );

    }

    /**
     *
     *   Trash update method
     */
    public function updatePostTrash( $id, $val ) {
        $data = Post::findOrFail( $id );

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
     *
     *   Thumbnail update method
     */
    public function updatePostThumbnail( $id, $val ) {
        $data = Post::findOrFail( $id );

        if ( $val == 1 ) {
            $data->post_thumbnail = false;
            $data->update();
            return 'Data thumbnail remove Succcessfully ): ';
        } else {
            $data->post_thumbnail = true;
            $data->update();
            return 'Data thumbnail added Succcessfully ): ';
        }

    }

    /**
     * Language Delete
     */
    public function deleteByAjax( Request $request ) {

        $data = Post::find($request->id);

        if($data != null){

            $data->categories()->detach();
            $data->tags()->detach();

            $data->delete();

            return response()->json([
                'success' => 'Post delete successfully ): '
            ]);
        }else {
            return response()->json([
                'error' => 'Something is wrong! plase try again! '
            ]);
        }

    }

}
