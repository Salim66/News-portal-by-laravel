@extends('backend.master')


@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
       <div class="content-header row">
          <div class="content-header-left col-12 mb-2 mt-1">
             <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0">Sub Categories</h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                   <ol class="breadcrumb p-0 mb-0 pl-1">
                      <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                      </li>
                      <li class="breadcrumb-item active">Sub Categories List
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
                           Sub Categories List
                        </h4>

                        <a class="btn btn-sm btn-primary float-right" data-toggle="modal" href="#add_category_modal" ><i class="fas fa-plus"></i> Add New Sub Categories</a>
                        <div style="display: flex; margin-left: 0px; width: 100%;">
                            <a class="badge badge-primary" href="{{ route('sub-category-list.index') }}">Published</a>
                            <a style="margin-left: 5px;" class="badge badge-danger" href="{{ route('sub-categories.trash') }}">Trash</a>
                        </div>
                      </div>
                      <div class="card-body card-dashboard">
                        <div class="table-responsive">

                            <table id="sub_category_table" class="table table-striped">
                                <thead>
                                    <tr role="row">
                                        <th>Language</th>
                                        <th>Category</th>
                                        <th>Parent Category</th>
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

        </div>
    </div>

     {{-- Category edit modal --}}
    <div id="edit_category_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-title pt-3">
                    <h5 class="d-inline float-left ml-3">Edit Sub Category</h5>
                    <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <form class="needs-validation" id="edit_category_form" novalidate="">
                    <div class="form-row">

                    @php
                        $languages = App\Models\Language::all();
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="validationCustom03">Language</label>
                          <select name="language_id" class="form-control language_id" id="validationCustom03" required>
                              <option selected value="">----Select Language----</option>
                              @foreach($languages as $language)
                              <option value="{{ $language->id }}">{{ $language->name }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="validationCustom01">Category</label>
                        <input
                          class="form-control c_name"
                          id="validationCustom01"
                          type="text"
                          name="name"
                          placeholder="Category"
                          required=""
                        />
                        <input type="hidden" name="id" class="cat_id">
                      </div>
                    </div>
                    @php
                        $categories = App\Models\Category::where('parent_id', null)->where('trash', false)->where('status', true)->get();
                    @endphp
                    <div class="col-md-12">
                      <div class="form-group">
                            <label for="validationCustom02">Parent Category</label>
                            <select name="parent_id" class="form-control parent_id" id="validationCustom03" required>
                                <option selected value="">----Select Category----</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                      </div>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="validationCustom04">Descriptiopn</label>
                            <textarea name="description" id="description" class="form-control c_description" rows="5"></textarea>
                        </div>
                    </div>   

                    <button class="btn btn-primary" type="submit">
                        Update user
                    </button>
                    </form>
                </div>
                <div></div>
            </div>
        </div>
    </div>

</div>
<!-- END: Content-->

 {{-- Category add modal --}}
<div id="add_category_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-title pt-3">
                <h5 class="d-inline float-left ml-3">Add Sub Category</h5>
                <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" id="category_add_form" novalidate="">
                  <div class="form-row">
                    @php
                        $languages = App\Models\Language::all();
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="validationCustom03">Language</label>
                          <select name="language_id" class="form-control" id="validationCustom03" required>
                              <option selected disabled>----Select Language----</option>
                              @foreach($languages as $language)
                              <option value="{{ $language->id }}">{{ $language->name }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="validationCustom01">Category</label>
                        <input
                          class="form-control"
                          id="validationCustom01"
                          type="text"
                          name="name"
                          placeholder="Category"
                          required=""
                        />
                      </div>
                    </div>
                    @php
                        $categories = App\Models\Category::where('parent_id', null)->where('trash', false)->where('status', true)->get();
                    @endphp
                    <div class="col-md-12">
                      <div class="form-group">
                            <label for="validationCustom02">Parent Category</label>
                            <select name="parent_id" class="form-control user_type" id="validationCustom03" required>
                                <option selected disabled>----Select Category----</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                      </div>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="validationCustom04">Descriptiopn</label>
                            <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                        </div>
                    </div>

                  <button class="btn btn-primary" type="submit">
                    Add category
                  </button>
                </form>
            </div>
            <div></div>
        </div>
    </div>
</div>



@endsection
