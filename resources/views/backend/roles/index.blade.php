@extends('backend.master')


@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
       <div class="content-header row">
          <div class="content-header-left col-12 mb-2 mt-1">
             <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0">Roles</h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                   <ol class="breadcrumb p-0 mb-0 pl-1">
                      <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                      </li>
                      <li class="breadcrumb-item active">Roles List
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
                            Roles List
                        </h4>

                        <a class="btn btn-sm btn-primary float-right" data-toggle="modal" href="#add_role_modal" ><i class="fas fa-plus"></i> Add New Role</a>
                        <div style="display: flex; margin-left: 0px; width: 100%;">
                            <a class="badge badge-primary" href="{{ route('role-list.index') }}">Published</a>
                            <a style="margin-left: 5px;" class="badge badge-danger" href="{{ route('roles.trash') }}">Trash</a>
                        </div>
                      </div>
                      <div class="card-body card-dashboard">
                        <div class="table-responsive">

                            <table id="role_table" class="table table-striped">
                                <thead>
                                    <tr role="row">
                                        <th>SL</th>
                                        <th>Role</th>
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

     {{-- Role edit modal --}}
    <div id="edit_role_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-title pt-3">
                    <h5 class="d-inline float-left ml-3">Edit Role</h5>
                    <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="edit_role_form" novalidate="">
                        <div class="form-row">
        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom05">Role Name</label>
                                    <input type="hidden" name="id" class="role_id">
                                    <input
                                        class="form-control role"
                                        id="validationCustom05"
                                        type="text"
                                        name="role"
                                        placeholder="Role Name"
                                        required=""
                                    />
                                </div>
                            </div>
                            
        
                            <button class="btn btn-primary" type="submit">
                                Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- END: Content-->

 {{-- Role add modal --}}
<div id="add_role_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-title pt-3">
                <h5 class="d-inline float-left ml-3">Add Role</h5>
                <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" id="role_add_form" novalidate="">
                  <div class="form-row">

                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="validationCustom01">Role Name</label>
                        <input
                          class="form-control"
                          id="validationCustom01"
                          type="text"
                          name="role"
                          placeholder="Role Name"
                          required=""
                        />
                      </div>
                    </div>
                                      

                    <button class="btn btn-primary" type="submit">
                        Add role
                    </button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
