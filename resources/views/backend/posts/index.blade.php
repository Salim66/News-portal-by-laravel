@extends('backend.master')


@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
       <div class="content-header row">
          <div class="content-header-left col-12 mb-2 mt-1">
             <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0">Posts</h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                   <ol class="breadcrumb p-0 mb-0 pl-1">
                      <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                      </li>
                      <li class="breadcrumb-item active">Posts List
                      </li>
                   </ol>
                </div>
             </div>
          </div>
       </div>
       <div class="content-body">

            <!-- Column selectors with Export Options and print table -->
            <section id="column-selectors">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">
                            Posts List
                        </h4>

                        <a class="btn btn-sm btn-primary float-right" data-toggle="modal" href="#add_post_modal" ><i class="fas fa-plus"></i> Add New Posts</a>
                        <div style="display: flex; margin-left: 0px; width: 100%;">
                            <a class="badge badge-primary" href="{{ route('post-list.index') }}">Published</a>
                            <a style="margin-left: 5px;" class="badge badge-danger" href="{{ route('posts.trash') }}">Trash</a>
                        </div>
                      </div>
                      <div class="card-body card-dashboard">
                        <div class="table-responsive">

                            <table id="post_table" class="table table-striped">
                                <thead>
                                    <tr role="row">
                                        <th>Language</th>
                                        <th>Post Title</th>
                                        <th>Post Type</th>
                                        <th>Thumbnail Post <span class="text-danger">(Choose only one)</span></th>
                                        <th>Status</th>
                                        <th>Trash</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                            </table>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            <!-- Column selectors with Export Options and print table -->


            {{--    Post Preview Modal--}}
            <div id="post_details_modal" class="modal fade" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-xl zoomIn animated">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="m-auto">Single Post Information</h2>
                            <button class="close" style="float: right;" data-dismiss="modal"
                                id="remove_gallary_image">&times;</button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-hover table-responsive">
                                <tr id="p_type">
                                    <td style="font-weight: bold" width="200">Post Type</td>
                                    <td id="post_type"></td>
                                </tr>
                                <tr id="p_t">
                                    <td style="font-weight: bold" width="200">Post Title</td>
                                    <td id="post_title"></td>
                                </tr>
                                <tr id="p_s">
                                    <td style="font-weight: bold" width="200">Post Slug</td>
                                    <td id="post_slug"></td>
                                </tr>
                                <tr id="p_c">
                                    <td style="font-weight: bold" width="200">Post Category</td>
                                    <td id="post_category"></td>
                                </tr>
                                <tr id="p_tag">
                                    <td style="font-weight: bold" width="200">Post Tag</td>
                                    <td id="post_tag"></td>
                                </tr>
                                <tr id="p_sta">
                                    <td style="font-weight: bold" width="200">Post Status</td>
                                    <td id="post_status"></td>
                                </tr>
                                <tr id="p_i">
                                    <td style="font-weight: bold" width="200">Post Image</td>
                                    <td id="post_image"><img width="300" src="" alt=""></td>
                                </tr>
                                <tr id="p_g">
                                    <td style="font-weight: bold" width="200">Post Gallery Image</td>
                                    <td id="post_g_image"></td>
                                </tr>
                                <tr id="p_a">
                                    <td style="font-weight: bold" width="200">Post Audio</td>
                                    <td id="post_audio"></td>
                                </tr>
                                <tr id="p_v">
                                    <td style="font-weight: bold" width="200">Post Video</td>
                                    <td id="post_video"></td>
                                </tr>
                                <tr id="p_con">
                                    <td style="font-weight: bold" width="200">Post Content</td>
                                    <td id="post_content"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button class="close" style="float: right;" data-dismiss="modal"
                                id="remove_gallary_image">&times;</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

     {{-- Post edit modal --}}
    <div id="edit_post_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-title pt-3">
                    <h5 class="d-inline float-left ml-3">Edit Tag</h5>
                    <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="edit_post_form" novalidate="">
                        <div class="form-row">

                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="validationCustom03">Post Type</label>
                                <select name="post_type" class="form-control p_post_type" id="edit_post_format">
                                    <option selected disabled>----Select Post Type----</option>
                                    <option value="Image">Image</option>
                                    <option value="Gallery">Gallery</option>
                                    <option value="Audio">Audio</option>
                                    <option value="Video">Video</option>
                                </select>
                                </div>
                            </div>
                            @php
                                $languages = App\Models\Language::where('status', true)->where('trash', false)->get();
                            @endphp
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="validationCustom03">Language</label>
                                <select name="language_id" class="form-control p_language_id" id="validationCustom03">
                                    <option selected disabled>----Select Language----</option>
                                    @foreach($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            @php
                                $categories = App\Models\Category::where('status', true)->where('trash', false)->get();
                            @endphp
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Category</label>
                                <select name="category_id[]" class="select2-size-sm form-control p_category_id" id="category_id" multiple>


                                </select>
                                </div>
                            </div>
                            @php
                                $tags = App\Models\Tag::where('status', true)->where('trash', false)->get();
                            @endphp
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Tag</label>
                                <select name="tag_id[]" class="select2-size-sm form-control p_tag_id" id="tag_id" multiple>


                                </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                            <div class="form-group">
                                <label>Post Title</label>
                                <input
                                class="form-control p_title"
                                type="text"
                                name="title"
                                placeholder="Post Title"
                                required=""
                                />
                                <input type="hidden" name="id" class="p_edit_id">
                            </div>
                            </div>
                            <div class="col-md-12">
                            <div class="form-group">
                                <label>Keyword Meta Tag</label>
                                <input
                                class="form-control p_meta"
                                type="text"
                                name="keyword_meta_tag"
                                placeholder="Keyword Meta Tag"
                                required=""
                                />
                            </div>
                            </div>
                            <div class="form-group col-md-12 post_image">
                                <img id="post_image_load" class="post_image" style="width: 400px;" src="" class="d-block" alt=""><br>
                                {{-- <label for="post_image"><img style="width: 100px; cursor: pointer;" src="{{ URL::to('/') }}/backend/assets/images/image-file.png" alt=""></label> --}}
                                <input type="file" name="post_image" class="form-control dropify" id="post_image">
                            </div>
                            <div class="form-group col-md-12 post_image_g">
                                <div class="post_gallery_image"></div>
                                {{-- <br>
                                <br>
                                <label for="post_image_g"><img style="width: 100px; cursor: pointer;" src="{{ URL::to('/') }}/backend/assets/images/image-file.png" alt=""></label> --}}
                                <input type="file" name="post_gallery_image[]" class="form-control dropify" id="post_image_g" multiple>
                            </div>
                            <div class="form-group col-md-12 post_image_a">
                                <label for="">Post Audio Link</label>
                                <input type="text" name="post_audio" class="form-control post_audio">
                            </div>
                            <div class="form-group col-md-12 post_image_v">
                                <label for="">Post Video Link</label>
                                <input type="text" name="post_video" class="form-control post_video">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="description" id="content2" rows="2" class="form-control p_description"></textarea>
                                </div>
                            </div>


                            <button class="btn btn-primary" type="submit">
                                Update post
                            </button>
                        </div>
                    </form>
                </div>
                <div></div>
            </div>
        </div>
    </div>

</div>
<!-- END: Content-->

 {{-- Post add modal --}}
<div id="add_post_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-title pt-3">
                <h5 class="d-inline float-left ml-3">Add Post</h5>
                <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" id="post_add_form" novalidate="" enctype="multipart/form-data">
                  <div class="form-row">

                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="validationCustom03">Post Type</label>
                          <select name="post_type" class="form-control" id="post_format">
                              <option selected disabled>----Select Post Type----</option>
                              <option value="Image">Image</option>
                              <option value="Gallery">Gallery</option>
                              <option value="Audio">Audio</option>
                              <option value="Video">Video</option>
                          </select>
                        </div>
                    </div>
                    @php
                        $languages = App\Models\Language::where('status', true)->where('trash', false)->get();
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="validationCustom03">Language</label>
                          <select name="language_id" class="form-control" id="validationCustom03">
                              <option selected disabled>----Select Language----</option>
                              @foreach($languages as $language)
                              <option value="{{ $language->id }}">{{ $language->name }}</option>
                              @endforeach
                          </select>
                        </div>
                    </div>
                    @php
                        $categories = App\Models\Category::where('status', true)->where('trash', false)->get();
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Category</label>
                          <select name="category_id[]" class="select2-size-sm form-control" multiple>
                              {{-- <option selected disabled>----Select Category----</option> --}}
                              @foreach($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endforeach
                          </select>
                        </div>
                    </div>
                    @php
                        $tags = App\Models\Tag::where('status', true)->where('trash', false)->get();
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Tag</label>
                          <select name="tag_id[]" class="select2-size-sm form-control" multiple>
                              {{-- <option selected disabled>----Select Tag----</option> --}}
                              @foreach($tags as $tag)
                              <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                              @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Post Title</label>
                        <input
                          class="form-control a_p_title"
                          type="text"
                          name="title"
                          placeholder="Post Title"
                          required=""
                        />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Keyword Meta Tag</label>
                        <input
                          class="form-control"
                          type="text"
                          name="keyword_meta_tag"
                          placeholder="Keyword Meta Tag"
                          required=""
                        />
                      </div>
                    </div>
                    <div class="form-group col-md-12 post_image">
                        <input type="file" name="post_image" class="form-control dropify" id="post_image">
                    </div>
                    <div class="form-group col-md-12 post_image_g">
                        <div class="post_gallery_image"></div>
                        <br>
                        <br>
                        <input type="file" name="post_gallery_image[]" class="form-control dropify" id="post_image_g" multiple>
                    </div>
                    <div class="form-group col-md-12 post_image_a">
                        <label for="">Post Audio Link</label>
                        <input type="text" name="post_audio" class="form-control">
                    </div>
                    <div class="form-group col-md-12 post_image_v">
                        <label for="">Post Video Link</label>
                        <input type="text" name="post_video" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="description" id="content1" rows="2" class="form-control"></textarea>
                        </div>
                    </div>


                    <button class="btn btn-primary" type="submit">
                        Add post
                    </button>
                </form>
            </div>
            <div></div>
        </div>
    </div>
</div>





@endsection
