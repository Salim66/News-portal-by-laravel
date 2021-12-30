@extends('backend.master')


@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
       <div class="content-header row">
          <div class="content-header-left col-12 mb-2 mt-1">
             <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0">Languages</h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                   <ol class="breadcrumb p-0 mb-0 pl-1">
                      <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                      </li>
                      <li class="breadcrumb-item active">Languages List
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
                            Languages List
                        </h4>

                        <a class="btn btn-sm btn-primary float-right" data-toggle="modal" href="#add_language_modal" ><i class="fas fa-plus"></i> Add New Language</a>
                        <div style="display: flex; margin-left: 0px; width: 100%;">
                            <a class="badge badge-primary" href="{{ route('language-list.index') }}">Published</a>
                            <a style="margin-left: 5px;" class="badge badge-danger" href="{{ route('languages.trash') }}">Trash</a>
                        </div>
                      </div>
                      <div class="card-body card-dashboard">
                        <div class="table-responsive">

                            <table id="language_table" class="table table-striped">
                                <thead>
                                    <tr role="row">
                                        <th>SL</th>
                                        <th>Name</th>
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

     {{-- Language edit modal --}}
    <div id="edit_language_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-title pt-3">
                    <h5 class="d-inline float-left ml-3">Edit Language</h5>
                    <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="edit_language_form" novalidate="">
                        <div class="form-row">
        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom05">Language Name</label>
                                    <input type="hidden" name="id" class="id">
                                    <input
                                        class="form-control lan_name"
                                        id="validationCustom05"
                                        type="text"
                                        name="name"
                                        placeholder="Language Name"
                                        required=""
                                    />
                                    <input type="hidden" name="id" class="lan_id">
                                </div>
                            </div>
                            
        
                            <button class="btn btn-primary" type="submit">
                                Update language
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- END: Content-->

 {{-- Language add modal --}}
<div id="add_language_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-title pt-3">
                <h5 class="d-inline float-left ml-3">Add Language</h5>
                <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" id="language_add_form" novalidate="">
                  <div class="form-row">

                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="validationCustom01">Language Name</label>
                        <input
                          class="form-control"
                          id="validationCustom01"
                          type="text"
                          name="name"
                          placeholder="Language Name"
                          required=""
                        />
                      </div>
                    </div>
                                      

                    <button class="btn btn-primary" type="submit">
                        Add language
                    </button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
