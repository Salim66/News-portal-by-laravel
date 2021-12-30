@extends('backend.master')


@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body"><!-- users view start -->
        <section class="users-view">
        <!-- users view media object start -->
        <div class="row">
        <div class="col-12 col-sm-7">
            <div class="media mb-2">
            <a class="mr-1" href="javascript:void(0);">
                <img src="{{ URL::to('') }}/media/users/{{ Auth::user()->photo }}" alt="users view avatar"
                class="users-avatar-shadow rounded-circle" height="64" width="64">
            </a>
            <div class="media-body pt-25">
                <h4 class="media-heading"><span class="users-view-name">{{ Auth::user()->name }} </span><br>
                <small>User Type:</small>
                <small>{{ Auth::user()->userType->role }}</small>
            </div>
            </div>
        </div>
        <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
            <a href="javascript:void(0);" class="btn btn-sm mr-25 border"><i class="bx bx-envelope font-small-3"></i></a>
            <a href="javascript:void(0);" class="btn btn-sm mr-25 border">Profile</a>
            <a href="#" class="btn btn-sm btn-primary user_profile_edit" edit_id="{{ Auth::user()->id }}">Edit</a>
            <a href="#change_password" data-toggle="modal" class="btn btn-sm bg-primary bg-lighten-5 text-white ml-25" edit_id="{{ Auth::user()->id }}">Change Password</a>
        </div>
        </div>
        <!-- users view media object ends -->
        <!-- users view card details start -->
        <div class="card">
        <div class="card-body">
            <div class="row bg-primary bg-lighten-5 rounded mb-2 mx-25 text-center text-lg-left">
            <div class="col-12 col-sm-4 p-2">
                <h6 class="text-primary mb-0">Posts: <span class="font-large-1 align-middle">125</span></h6>
            </div>
            </div>
            <div class="col-12">
            <table class="table table-borderless">
                <tbody>
                <tr>
                    <td>Name:</td>
                    <td class="users-view-name">{{ Auth::user()->name }}</td>
                </tr>
                <tr>
                    <td>E-mail:</td>
                    <td class="users-view-email">{{ Auth::user()->email }}</td>
                </tr>
                <tr>
                    <td>Cell:</td>
                    <td class="users-view-email">{{ Auth::user()->cell }}</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>{{ Auth::user()->address }}</td>
                </tr>

                </tbody>
            </table>
        </div>
        </div>
        <!-- users view card details ends -->

        </section>
        <!-- users view ends -->

      </div>
    </div>

    {{-- Change Password --}}
    <div id="change_password" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-lg zoomIn animated">
            <div class="modal-content">
                <div class="modal-title mt-3">
                    <h5 class="d-inline float-left ml-3">Change Password</h5>
                    <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <form action="" method="POST" class="needs-validation" id="change_password_form" novalidate="" enctype="multipart/form-data">
                    <div class="form-row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="validationCustom01">Old Password</label>
                                <input type="hidden" name="id" class="id" value="{{ Auth::id() }}">
                                <input
                                class="form-control old_password"
                                id="validationCustom01"
                                type="text"
                                name="old_password"
                                placeholder="Old Password"
                                required=""
                                />
                            </div>
                        </div>                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="validationCustom01">New Password</label>
                                <input
                                class="form-control new_password"
                                id="validationCustom01"
                                type="text"
                                name="new_password"
                                placeholder="New Password"
                                required=""
                                />
                            </div>
                        </div>                    

                        <button class="btn btn-primary" type="submit">
                            Update password
                        </button>
                    </form>
                </div>
                <div></div>
            </div>
        </div>
    </div>

  </div>

  {{-- User Profile Edit --}}
  <div id="edit_user_prifile" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-lg zoomIn animated">
        <div class="modal-content">
            <div class="modal-title mt-3">
                <h5 class="d-inline float-left ml-3">Edit Profile</h5>
                <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form action="" method="POST" class="needs-validation" id="user_profile_edit" novalidate="" enctype="multipart/form-data">
                  <div class="form-row">

                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="validationCustom01">Full name</label>
                        <input type="hidden" name="id" class="id">
                        <input
                          class="form-control f_name"
                          id="validationCustom01"
                          type="text"
                          name="name"
                          placeholder="First name"
                          required=""
                        />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="validationCustom02">Email</label>
                        <input
                          class="form-control f_email"
                          id="validationCustom02"
                          type="email"
                          name="email"
                          placeholder="Last name"
                          required=""
                        />
                      </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="validationCustom02">Cell</label>
                            <input
                            class="form-control f_cell"
                            id="validationCustom02"
                            type="text"
                            name="cell"
                            placeholder="Cell"
                            required=""
                            />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="validationCustom02">Address</label>
                            <input
                            class="form-control f_address"
                            id="validationCustom02"
                            type="text"
                            name="address"
                            placeholder="Address"
                            required=""
                            />
                        </div>
                    </div>
                    <div class="col-md-12" class=" " >
                        <div class="form-group">
                            <label for="image_file"><i class="far fa-file-image text-success" style="font-size: 70px; margin-right: 200px; cursor: pointer;"></i></label>
                            <input type="file" name="photo" style="display: none" id="image_file" class="f_photo_val">
                            <img id="user_photo" src=""  alt="" style="width: 200px; height: auto; border: 1px solid #9900ff" class="shadow f_photo_show" onerror="this.src='/media/users/avatar-s-11.jpg'">
                        </div>
                    </div>


                    <button class="btn btn-primary" type="submit">
                        Update profile
                    </button>
                    <button class="close ml-auto" type="button" data-dismiss="modal">
                        &times;
                    </button>
                </form>
            </div>
            <div></div>
        </div>
    </div>
</div>
@endsection