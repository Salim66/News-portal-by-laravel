@extends('backend.master')


@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
       <div class="content-header row">
          <div class="content-header-left col-12 mb-2 mt-1">
             <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0">Social Link</h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                   <ol class="breadcrumb p-0 mb-0 pl-1">
                      <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                      </li>
                      <li class="breadcrumb-item active">Social Link List
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
                            Social Link List
                        </h4>

                        <a class="btn btn-sm btn-primary float-right" data-toggle="modal" href="#add_social_modal" ><i class="fas fa-plus"></i> Add New Social Link</a>
                        <div style="display: flex; margin-left: 0px; width: 100%;">
                            <a class="badge badge-primary" href="{{ route('social-list.index') }}">Published</a>
                            <a style="margin-left: 5px;" class="badge badge-danger" href="{{ route('socials.trash') }}">Trash</a>
                        </div>
                      </div>
                      <div class="card-body card-dashboard">
                        <div class="table-responsive">

                            <table id="social_table" class="table table-striped">
                                <thead>
                                    <tr role="row">
                                        <th>Language</th>
                                        <th>Icon</th>
                                        <th>Name</th>
                                        <th>Link</th>
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

     {{-- Social edit modal --}}
    <div id="edit_social_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-title pt-3">
                    <h5 class="d-inline float-left ml-3">Edit Social Link</h5>
                    <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <form class="needs-validation" id="edit_social_form" novalidate="">
                    <div class="form-row">

                    @php
                        $languages = App\Models\Language::all();
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="validationCustom03">Language</label>
                          <select name="language_id" class="form-control language_id" id="validationCustom03">
                              <option selected value="">----Select Language----</option>
                              @foreach($languages as $language)
                              <option value="{{ $language->id }}">{{ $language->name }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="validationCustom01">Social Name</label>
                        <input
                          class="form-control social_name"
                          id="validationCustom01"
                          type="text"
                          name="name"
                          placeholder="Social Name"
                          required=""
                        />
                        <input type="hidden" name="id" class="social_id">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="validationCustom02">Social Link</label>
                        <input
                          class="form-control social_link"
                          id="validationCustom02"
                          type="text"
                          name="link"
                          placeholder="Social Link"
                          required=""
                        />
                      </div>
                    </div>
                    <div class="input-group mb-3">
                        <label for="" class="w-100">Social Icon</label><br>
                        <span class="input-group-prepend">
                            <button class="btn btn-secondary" name="icon" id="update_social_icon" data-icon="ion-ionic" role="iconpicker">
                                <i id="icon_pic" class="fab fa-accessible-icon"></i>
                                <input type="hidden" name="icon" id="icon_up" value="fab fa-accessible-icon">
                            </button>
                        </span>
                        <input type="text" id="edit_social_icon_name" class="form-control" autocomplete="off">
                    </div><br>

                    <button class="btn btn-primary" type="submit">
                        Update social link
                    </button>
                    </form>
                </div>
                <div></div>
            </div>
        </div>
    </div>

</div>
<!-- END: Content-->

 {{-- Social add modal --}}
<div id="add_social_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-title pt-3">
                <h5 class="d-inline float-left ml-3">Add Social Link</h5>
                <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" id="social_add_form" novalidate="">
                  <div class="form-row">
                    @php
                        $languages = App\Models\Language::all();
                    @endphp
                    <div class="col-md-12">
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
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="validationCustom01">Social Name</label>
                        <input
                          class="form-control"
                          id="validationCustom01"
                          type="text"
                          name="name"
                          placeholder="Social Name"
                          required=""
                        />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="validationCustom02">Social Link</label>
                        <input
                          class="form-control"
                          id="validationCustom02"
                          type="text"
                          name="link"
                          placeholder="Social Link"
                          required=""
                        />
                      </div>
                    </div>
                    {{-- <div class="input-group mb-3">
                        <label for="" class="w-100">Icon</label><br>
                        <span class="input-group-prepend">
                            <button class="btn btn-secondary" id="category_icon" data-iconset="ionicon" data-icon="ion-ionic" role="iconpicker"></button>
                        </span>
                        <input type="text" id="add_icon_name" class="form-control" autocomplete="off">
                    </div><br><br> --}}
                    <div class="input-group mb-3">
                        <label for="" class="w-100">Social Icon</label><br>
                        <span class="input-group-prepend">
                            <button class="btn btn-secondary" name="icon" id="social_icon" data-icon="" role="iconpicker">
                                <i id="icon_pic" class="fab fa-accessible-icon"></i>
                                <input type="hidden" name="icon" value="fab fa-accessible-icon">
                            </button>
                        </span>
                        <input type="text" id="icon_name" class="form-control" autocomplete="off">
                    </div><br>

                  <button class="btn btn-primary" type="submit">
                    Add social link
                  </button>
                </form>
            </div>
            <div></div>
        </div>
    </div>
</div>



@endsection
