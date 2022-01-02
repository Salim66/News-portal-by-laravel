@extends('backend.master')


@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
       <div class="content-header row">
          <div class="content-header-left col-12 mb-2 mt-1">
             <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0">Footers</h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                   <ol class="breadcrumb p-0 mb-0 pl-1">
                      <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                      </li>
                      <li class="breadcrumb-item active">Footers List
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
                            Footers List
                        </h4>

                        <a class="btn btn-sm btn-primary float-right" data-toggle="modal" href="#add_footer_modal" ><i class="fas fa-plus"></i> Add New Footers</a>
                        <div style="display: flex; margin-left: 0px; width: 100%;">
                            <a class="badge badge-primary" href="{{ route('footer-list.index') }}">Published</a>
                            <a style="margin-left: 5px;" class="badge badge-danger" href="{{ route('footers.trash') }}">Trash</a>
                        </div>
                      </div>
                      <div class="card-body card-dashboard">
                        <div class="table-responsive">

                            <table id="footer_table" class="table table-striped">
                                <thead>
                                    <tr role="row">
                                        <th>Language</th>
                                        <th>Copy Right</th>
                                        <th>Footer Text</th>
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

     {{-- Footer edit modal --}}
    <div id="edit_footer_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-title pt-3">
                    <h5 class="d-inline float-left ml-3">Edit Footer</h5>
                    <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <form class="needs-validation" id="edit_footer_form" novalidate="">
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
                        <label for="validationCustom01">Copyright Text</label>
                        <input
                          class="form-control c_r_text"
                          id="validationCustom01"
                          type="text"
                          name="copyright_text"
                          placeholder="Copyright Text"
                          required=""
                        />
                        <input type="hidden" name="id" class="footer_id">
                      </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="validationCustom04">Footer Text</label>
                            <textarea name="footer_text" id="footer_text" class="form-control footer_text" rows="5"></textarea>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">
                        Update footer
                    </button>
                    </form>
                </div>
                <div></div>
            </div>
        </div>
    </div>

</div>
<!-- END: Content-->

 {{-- Footer add modal --}}
<div id="add_footer_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-title pt-3">
                <h5 class="d-inline float-left ml-3">Add Footer</h5>
                <button class="close d-inline float-right mr-3" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" id="footer_add_form" novalidate="">
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
                        <label for="validationCustom01">Copy Right Text</label>
                        <input
                          class="form-control"
                          id="validationCustom01"
                          type="text"
                          name="copyright_text"
                          placeholder="Copyright Text"
                          required=""
                        />
                      </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="validationCustom04">Footer Text</label>
                            <textarea name="footer_text" id="footer_text" class="form-control" rows="5"></textarea>
                        </div>
                    </div>

                  <button class="btn btn-primary" type="submit">
                    Add footer
                  </button>
                </form>
            </div>
            <div></div>
        </div>
    </div>
</div>



@endsection
