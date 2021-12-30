(function($){
    $(document).ready(function(){

        //CK Editor
        CKEDITOR.replace('content1');
        CKEDITOR.replace('content2');

        // Drofify js
        $(".dropify").dropify({
            messages: {
                default: "Drag and drop a file here or click",
                replace: "Drag and drop or click to replace",
                remove: "Remove",
                error: "Ooops, something wrong happended.",
            },
        });

        //================= Users ================//

        //user Table load by yijra datatable
        $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/users/list'
            },
            columns: [
                {
                    data: 'photo',
                    name: 'photo',
                    render: function (data, type, full, meta) {
                        return `<img class="user_photo_list" src="/media/users/${data}" alt="">`;
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'user_type',
                    name: 'user_type'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input user_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input user_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });


        //user Trash Table load by yijra datatable
        $('#user_trash_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/users/trash-list'
            },
            columns: [
                {
                    data: 'photo',
                    name: 'photo',
                    render: function (data, type, full, meta) {
                        return `<img class="user_photo_list" src="/media/users/${data}" alt="">`;
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'user_type',
                    name: 'user_type'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input user_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input user_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });


        // User add by ajax
        $(document).on('submit', '#user_add_form', function (e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/users/list',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    $.notify(data.success, {
                        globalPosition: "top right",
                        className: "success"
                    });
                    $('#user_add_form')[0].reset();
                    $('#add_user_modal').modal('hide');
                    $('#user_table').DataTable().ajax.reload();
                }
            });
        });

        //User Status update
        $(document).on("change", "input.user_status_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();
            // alert(value);

            $.ajax({
                url: "/users/admin-status-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#user_table').DataTable().ajax.reload();
                    $('#user_trash_table').DataTable().ajax.reload();

                }
            });
        });


        //User trash update
        $(document).on("change", "input.user_trash_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();

            $.ajax({
                url: "/users/admin-trash-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#user_table').DataTable().ajax.reload();
                    $('#user_trash_table').DataTable().ajax.reload();

                }
            });
        });


        // user edit data show modal admin purpose
        $(document).on("click", ".edit_user_data", function (e) {
            e.preventDefault();
            let edit_id = $(this).attr("edit_id");
            // alert(edit_id);

            $.ajax({
                url: "/users/list/" + edit_id,
                type: "GET",
                success: function (data) {
                    $(".f_name").val(data.name);
                    $(".f_email").val(data.email);
                    $(".user_type").val(data.user_type);
                    $(".user_id").val(data.id);

                    $("#edit_users_modal").modal("show");
                },
            });
        });


        // user update by ajax
        $(document).on('submit', '#edit_user_form', function (e) {
            e.preventDefault();
            let id = $('.user_id').val();

            // alert(id);

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/users/admin-edit-store',
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {

                    $.notify(data.success, {
                        globalPosition: 'top right',
                        className: 'success'
                    });

                    $('#user_table').DataTable().ajax.reload();
                    $('#user_trash_table').DataTable().ajax.reload();
                    $('#edit_users_modal').modal('hide');

                },

            });

        });


        $(document).on('submit', '#user_delete_form', function (e) {
            e.preventDefault();
            let id = $('#delete_user').val();


            swal(
                {
                    title: "Are you sure?",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                    "content"
                                ),
                            },
                            url: '/users/delete',
                            method: 'POST',
                            data: { id: id },
                            success: function (data) {
                                swal(
                                    {
                                        title: "Deleted!",
                                        type: "success"
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            $.notify(data, {
                                                globalPosition: "top right",
                                                className: 'success'
                                            });
                                            // console.log(data);

                                            $('#user_table').DataTable().ajax.reload();
                                            $('#user_trash_table').DataTable().ajax.reload();
                                        }
                                    }
                                );
                            }
                        });

                    } else {
                        swal("Cancelled", "", "error");
                    }
                }
            );



        });


        //================= User Profile ================//
        // user profile edit
        $(document).on("click", ".user_profile_edit", function (e) {
            e.preventDefault();
            let edit_id = $(this).attr("edit_id");
            // alert(edit_id);

            $.ajax({
                url: "/profile/edit/" + edit_id,
                type: "GET",
                success: function (data) {
                    // console.log(data);
                    $(".id").val(data.id);
                    $(".f_name").val(data.name);
                    $(".f_email").val(data.email);
                    $(".f_cell").val(data.cell);
                    $(".f_address").val(data.address);
                    $(".f_photo_val").attr(
                        "src",
                        "media/users/" + data.photo
                    );
                    $(".f_photo_show").attr(
                        "src",
                        "/media/users/" + data.photo
                    );

                    $("#edit_user_prifile").modal("show");
                },
            });

        });

        //User image load
        $(document).on("change", "#image_file", function (e) {
            e.preventDefault();
            let image_url = URL.createObjectURL(e.target.files[0]);
            $("#user_photo").attr("src", image_url);
        });

         // user profile update
         $("#user_profile_edit").on("submit", function (e) {
            e.preventDefault();


            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                method: "POST",
                url: "/profile/update",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {

                    $.notify(data.success, {
                        globalPosition: "top right",
                        className: 'success'
                    });

                    $("#edit_user_prifile").modal("hide");

                }

            });
        });

        // User change password
        $("#change_password_form").on("submit", function (e) {
            e.preventDefault();
            let old_pass = $(".old_password").val();
            let new_pass = $(".new_password").val();
            // console.log(old_pass + " " + new_pass);

            if (
                old_pass == "" ||
                old_pass == null ||
                new_pass == "" ||
                new_pass == null
            ) {

                $.notify("Please fill all the field!", {
                    globalPosition: "top right",
                    className: 'error'
                });

            } else {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                            "content"
                        ),
                    },
                    method: "POST",
                    url: "/profile/update-password",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        // console.log(response);
                        $(".old_password").val("");
                        $(".new_password").val("");

                        $.notify(data.success, {
                            globalPosition: "top right",
                            className: 'success'
                        });

                        $('#change_password').modal('hide');

                    },
                });
            }
        });


        //================= Categories ================//

        //category Table load by yijra datatable
        $('#category_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/categories/category-list'
            },
            columns: [
                {
                    data: 'languages.name',
                    name: 'languages.name'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input category_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input category_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

         //category Table load by yijra datatable
         $('#sub_category_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/categories/sub-category-list'
            },
            columns: [
                {
                    data: 'languages.name',
                    name: 'languages.name'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'categories.name',
                    name: 'categories.name'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input category_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input category_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        //category Trash Table load by yijra datatable
        $('#category_trash_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/categories/category-trash-list'
            },
            columns: [
                {
                    data: 'languages.name',
                    name: 'languages.name'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input category_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input category_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        //category Trash Table load by yijra datatable
        $('#sub_category_trash_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/categories/sub-category-trash-list'
            },
            columns: [
                {
                    data: 'languages.name',
                    name: 'languages.name'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'categories.name',
                    name: 'categories.name'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input category_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input category_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });


        // Category add by ajax
        $(document).on('submit', '#category_add_form', function (e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/categories/category-list',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    $.notify(data.success, {
                        globalPosition: "top right",
                        className: "success"
                    });
                    $('#category_add_form')[0].reset();
                    $('#add_category_modal').modal('hide');
                    $('#category_table').DataTable().ajax.reload();
                    $('#sub_category_table').DataTable().ajax.reload();
                }
            });
        });

        // category edit data show modal admin purpose
        $(document).on("click", ".edit_category_data", function (e) {
            e.preventDefault();
            let edit_id = $(this).attr("edit_id");
            // alert(edit_id);

            $.ajax({
                url: "/categories/category-list/" + edit_id + '/edit',
                type: "GET",
                success: function (data) {
                    $(".language_id").val(data.language_id);
                    $(".c_name").val(data.name);
                    $(".parent_id").val(data.parent_id);
                    $(".c_description").html(data.description);
                    $(".cat_id").val(data.id);

                    $("#edit_category_modal").modal("show");
                },
            });
        });


        // user update by ajax
        $(document).on('submit', '#edit_category_form', function (e) {
            e.preventDefault();
            let id = $('.cat_id').val();

            // alert(id);

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/categories/category-edit-store',
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {

                    $.notify(data.success, {
                        globalPosition: 'top right',
                        className: 'success'
                    });
                    console.log(data);

                    $('#category_table').DataTable().ajax.reload();
                    $('#sub_category_table').DataTable().ajax.reload();
                    $('#category_trash_table').DataTable().ajax.reload();
                    $('#sub_category_trash_table').DataTable().ajax.reload();
                    $('#edit_category_modal').modal('hide');

                },

            });

        });


        //Category Status update
        $(document).on("change", "input.category_status_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();
            // alert(value);

            $.ajax({
                url: "/categories/category-status-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#category_table').DataTable().ajax.reload();
                    $('#category_trash_table').DataTable().ajax.reload();
                    $('#sub_category_table').DataTable().ajax.reload();
                    $('#sub_category_trash_table').DataTable().ajax.reload();

                }
            });

        });


        //Cateogry trash update
        $(document).on("change", "input.category_trash_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();

            // alert(id);

            $.ajax({
                url: "/categories/category-trash-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#category_table').DataTable().ajax.reload();
                    $('#category_trash_table').DataTable().ajax.reload();
                    $('#sub_category_table').DataTable().ajax.reload();
                    $('#sub_category_trash_table').DataTable().ajax.reload();

                }
            });
        });

        // Category delete
        $(document).on('submit', '#category_delete_form', function (e) {
            e.preventDefault();
            let id = $('#delete_category').val();
            // alert(id);

            swal(
                {
                    title: "Are you sure?",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                    "content"
                                ),
                            },
                            url: '/categories/delete',
                            method: 'POST',
                            data: { id: id },
                            success: function (data) {
                                swal(
                                    {
                                        title: "Deleted!",
                                        type: "success"
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            $.notify(data, {
                                                globalPosition: "top right",
                                                className: 'success'
                                            });
                                            console.log(data);

                                            $('#category_table').DataTable().ajax.reload();
                                            $('#category_trash_table').DataTable().ajax.reload();
                                            $('#sub_category_table').DataTable().ajax.reload();
                                            $('#sub_category_trash_table').DataTable().ajax.reload();
                                        }
                                    }
                                );
                            }
                        });

                    } else {
                        swal("Cancelled", "", "error");
                    }
                }
            );



        });


        //================= Languages ================//

        //language Table load by yijra datatable
        $('#language_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/languages/language-list'
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input language_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input language_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        //language Trash Table load by yijra datatable
        $('#language_trash_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/languages/language-trash-list'
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input language_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input language_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });


        // Language add by ajax
        $(document).on('submit', '#language_add_form', function (e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/languages/language-list',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    $.notify(data.success, {
                        globalPosition: "top right",
                        className: "success"
                    });
                    $('#language_add_form')[0].reset();
                    $('#add_language_modal').modal('hide');
                    $('#language_table').DataTable().ajax.reload();
                }
            });
        });

        // language edit data show modal admin purpose
        $(document).on("click", ".edit_language_data", function (e) {
            e.preventDefault();
            let edit_id = $(this).attr("edit_id");
            // alert(edit_id);

            $.ajax({
                url: "/languages/language-list/" + edit_id + '/edit',
                type: "GET",
                success: function (data) {
                    $(".lan_name").val(data.name);
                    $(".lan_id").val(data.id);

                    $("#edit_language_modal").modal("show");
                },
            });

        });


        // language update by ajax
        $(document).on('submit', '#edit_language_form', function (e) {
            e.preventDefault();
            let id = $('.lan_id').val();

            // alert(id);

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/languages/language-edit-store',
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {

                    $.notify(data.success, {
                        globalPosition: 'top right',
                        className: 'success'
                    });
                    console.log(data);

                    $('#language_table').DataTable().ajax.reload();
                    $('#language_trash_table').DataTable().ajax.reload();
                    $('#edit_language_modal').modal('hide');

                },

            });

        });


        //Language Status update
        $(document).on("change", "input.language_status_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();
            // alert(value);

            $.ajax({
                url: "/languages/language-status-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#language_table').DataTable().ajax.reload();
                    $('#language_trash_table').DataTable().ajax.reload();

                }
            });

        });


        //Language trash update
        $(document).on("change", "input.language_trash_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();

            // alert(id);

            $.ajax({
                url: "/languages/language-trash-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#language_table').DataTable().ajax.reload();
                    $('#language_trash_table').DataTable().ajax.reload();

                }
            });
        });

        // Language delete
        $(document).on('submit', '#language_delete_form', function (e) {
            e.preventDefault();
            let id = $('#delete_language').val();
            // alert(id);

            swal(
                {
                    title: "Are you sure?",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                    "content"
                                ),
                            },
                            url: '/languages/delete',
                            method: 'POST',
                            data: { id: id },
                            success: function (data) {
                                swal(
                                    {
                                        title: "Deleted!",
                                        type: "success"
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            $.notify(data, {
                                                globalPosition: "top right",
                                                className: 'success'
                                            });
                                            console.log(data);

                                            $('#language_table').DataTable().ajax.reload();
                                            $('#language_trash_table').DataTable().ajax.reload();
                                        }
                                    }
                                );
                            }
                        });

                    } else {
                        swal("Cancelled", "", "error");
                    }
                }
            );



        });


        //================= Tags ================//

        //tag Table load by yijra datatable
        $('#tag_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/tags/tag-list'
            },
            columns: [
                {
                    data: 'languages.name',
                    name: 'languages.name'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input tag_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input tag_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        //tag Trash Table load by yijra datatable
        $('#tag_trash_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/tags/tag-trash-list'
            },
            columns: [
                {
                    data: 'language_id',
                    name: 'language_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input tag_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input tag_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });


        // Tag add by ajax
        $(document).on('submit', '#tag_add_form', function (e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/tags/tag-list',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    $.notify(data.success, {
                        globalPosition: "top right",
                        className: "success"
                    });
                    $('#tag_add_form')[0].reset();
                    $('#add_tag_modal').modal('hide');
                    $('#tag_table').DataTable().ajax.reload();
                }
            });
        });

        // tag edit data show modal admin purpose
        $(document).on("click", ".edit_tag_data", function (e) {
            e.preventDefault();
            let edit_id = $(this).attr("edit_id");
            // alert(edit_id);

            $.ajax({
                url: "/tags/tag-list/" + edit_id + '/edit',
                type: "GET",
                success: function (data) {
                    $(".language_id").val(data.language_id);
                    $(".t_name").val(data.name);
                    $(".tag_id").val(data.id);

                    $("#edit_tag_modal").modal("show");
                },
            });
        });


        // tag update by ajax
        $(document).on('submit', '#edit_tag_form', function (e) {
            e.preventDefault();
            let id = $('.tag_id').val();

            // alert(id);

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/tags/tag-edit-store',
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {

                    $.notify(data.success, {
                        globalPosition: 'top right',
                        className: 'success'
                    });
                    // console.log(data);

                    $('#tag_table').DataTable().ajax.reload();
                    $('#tag_trash_table').DataTable().ajax.reload();
                    $('#edit_tag_modal').modal('hide');

                },

            });

        });


        //Tag Status update
        $(document).on("change", "input.tag_status_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();
            // alert(value);

            $.ajax({
                url: "/tags/tag-status-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#tag_table').DataTable().ajax.reload();
                    $('#tag_trash_table').DataTable().ajax.reload();

                }
            });

        });


        //Tag trash update
        $(document).on("change", "input.tag_trash_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();

            // alert(id);

            $.ajax({
                url: "/tags/tag-trash-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#tag_table').DataTable().ajax.reload();
                    $('#tag_trash_table').DataTable().ajax.reload();

                }
            });
        });

        // Tag delete
        $(document).on('submit', '#tag_delete_form', function (e) {
            e.preventDefault();
            let id = $('#delete_tag').val();
            // alert(id);

            swal(
                {
                    title: "Are you sure?",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                    "content"
                                ),
                            },
                            url: '/tags/delete',
                            method: 'POST',
                            data: { id: id },
                            success: function (data) {
                                swal(
                                    {
                                        title: "Deleted!",
                                        type: "success"
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            $.notify(data, {
                                                globalPosition: "top right",
                                                className: 'success'
                                            });
                                            console.log(data);

                                            $('#tag_table').DataTable().ajax.reload();
                                            $('#tag_trash_table').DataTable().ajax.reload();
                                        }
                                    }
                                );
                            }
                        });

                    } else {
                        swal("Cancelled", "", "error");
                    }
                }
            );


        });


        //================= Roles ================//

        //roles Table load by yijra datatable
        $('#role_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/roles/role-list'
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input role_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input role_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        //role Trash Table load by yijra datatable
        $('#role_trash_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/roles/role-trash-list'
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input role_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input role_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });


        // Role add by ajax
        $(document).on('submit', '#role_add_form', function (e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/roles/role-list',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    $.notify(data.success, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#role_add_form')[0].reset();
                    $('#add_role_modal').modal('hide');
                    $('#role_table').DataTable().ajax.reload();
                }
            });
        });

        // role edit data show modal admin purpose
        $(document).on("click", ".edit_role_data", function (e) {
            e.preventDefault();
            let edit_id = $(this).attr("edit_id");
            // alert(edit_id);

            $.ajax({
                url: "/roles/role-list/" + edit_id + '/edit',
                type: "GET",
                success: function (data) {
                    $(".role").val(data.role);
                    $(".role_id").val(data.id);

                    $("#edit_role_modal").modal("show");
                },
            });

        });


        // role update by ajax
        $(document).on('submit', '#edit_role_form', function (e) {
            e.preventDefault();
            let id = $('.role_id').val();

            // alert(id);

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/roles/role-edit-store',
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {

                    $.notify(data.success, {
                        globalPosition: 'top right',
                        className: 'success'
                    });
                    // console.log(data);

                    $('#role_table').DataTable().ajax.reload();
                    $('#role_trash_table').DataTable().ajax.reload();
                    $('#edit_role_modal').modal('hide');

                },

            });

        });


        //Role Status update
        $(document).on("change", "input.role_status_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();
            // alert(value);

            $.ajax({
                url: "/roles/role-status-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#role_table').DataTable().ajax.reload();
                    $('#role_trash_table').DataTable().ajax.reload();

                }
            });

        });


        //Role trash update
        $(document).on("change", "input.role_trash_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();

            // alert(id);

            $.ajax({
                url: "/roles/role-trash-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#role_table').DataTable().ajax.reload();
                    $('#role_trash_table').DataTable().ajax.reload();

                }
            });
        });

        // Role delete
        $(document).on('submit', '#role_delete_form', function (e) {
            e.preventDefault();
            let id = $('#delete_role').val();
            // alert(id);

            swal(
                {
                    title: "Are you sure?",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                    "content"
                                ),
                            },
                            url: '/roles/delete',
                            method: 'POST',
                            data: { id: id },
                            success: function (data) {
                                swal(
                                    {
                                        title: "Deleted!",
                                        type: "success"
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            $.notify(data, {
                                                globalPosition: "top right",
                                                className: 'success'
                                            });
                                            console.log(data);

                                            $('#role_table').DataTable().ajax.reload();
                                            $('#role_trash_table').DataTable().ajax.reload();
                                        }
                                    }
                                );
                            }
                        });

                    } else {
                        swal("Cancelled", "", "error");
                    }
                }
            );



        });


        //================= Posts ================//

        function postType(post_type) {
            // select psot type
            if (post_type == "Image") {
                $(".post_image").show();
            } else {
                $(".post_image").hide();
            }

            if (post_type == "Gallery") {
                $(".post_image_g").show();
            } else {
                $(".post_image_g").hide();
            }

            if (post_type == "Video") {
                $(".post_image_v").show();
            } else {
                $(".post_image_v").hide();
            }

            if (post_type == "Audio") {
                $(".post_image_a").show();
            } else {
                $(".post_image_a").hide();
            }
        }

        // Post Type Select
        $("#post_format").on("change", function (e) {
            let post_type = $(this).val();
            postType(post_type);
        });

        // Post image gallery load
        $(document).on("change", "#post_image_g", function (e) {
            e.preventDefault();

            let post_gellary_url = "";
            for (let i = 0; i < e.target.files.length; i++) {
                let image_url = URL.createObjectURL(e.target.files[i]);
                post_gellary_url +=
                    '<img class="shadow" style="width: 150px; margin-right: 10px" src="' +
                    image_url +
                    '" />';
            }

            $(".post_gallery_image").html(post_gellary_url);
        });

        //post Table load by yijra datatable
        $('#post_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/posts/post-list'
            },
            columns: [
                {
                    data: 'languages.name',
                    name: 'languages.name'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'post_type',
                    name: 'post_type'
                },
                {
                    data: 'post_thumbnail',
                    name: 'post_thumbnail',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input post_thumbnail_update" id="customSwitchThumbnailShadow${full.id}" ${full.post_thumbnail == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchThumbnailShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input post_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input post_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        //post Trash Table load by yijra datatable
        $('#post_trash_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/posts/post-trash-list'
            },
            columns: [
                {
                    data: 'languages.name',
                    name: 'languages.name'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'post_type',
                    name: 'post_type'
                },
                {
                    data: 'post_thumbnail',
                    name: 'post_thumbnail',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input post_thumbnail_update" id="customSwitchThumbnailShadow${full.id}" ${full.post_thumbnail == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchThumbnailShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input post_status_update" id="customSwitchShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input post_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });


        // post add by ajax
        $(document).on('submit', '#post_add_form', function (e) {
            e.preventDefault();

            let title = $(".a_p_title").val();

            if (title == "" || title == null) {
                $.notify('Post title is required!', {
                    globalPosition: "top right",
                    className: "error"
                });
            } else {
                // data pass by ckeditor
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                            "content"
                        ),
                    },
                    url: '/posts/post-list',
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        // console.log(data);
                        $.notify(data.success, {
                            globalPosition: "top right",
                            className: "success"
                        });
                        $('#post_add_form')[0].reset();
                        $(".select2-size-sm")
                            .val(null)
                            .trigger("change");
                        for (instance in CKEDITOR.instances) {
                            CKEDITOR.instances[instance].updateElement();
                            CKEDITOR.instances[instance].setData("");
                        }
                        $('#add_post_modal').modal('hide');
                        $('#post_table').DataTable().ajax.reload();
                    }
                });
            }

        });

        // post edit data show modal admin purpose
        $(document).on("click", ".edit_post_data", function (e) {
            e.preventDefault();
            let edit_id = $(this).attr("edit_id");
            // alert(edit_id);

            $.ajax({
                url: "/posts/post-list/" + edit_id + '/edit',
                type: "GET",
                success: function (data) {
                    // console.log(data.category_list);
                    const photo = JSON.parse(data.featured);
                    $(".p_edit_id").val(data.id);
                    $(".p_post_type").val(data.post_type);
                    $(".p_language_id").val(data.language_id);
                    $("#category_id").html(data.category_list);
                    $("#tag_id").html(data.tag_list);
                    $(".p_title").val(data.title);
                    $(".p_meta").val(data.keyword_meta_tag);
                    CKEDITOR.instances.content2.setData(
                        data.description,
                        function () {
                            this.checkDirty();
                        }
                    );
                    $("#post_image_load").attr(
                        "src",
                        "/media/posts/" + photo.post_image
                    );
                    $("#post_gallery_image").append(
                        "src",
                        "/media/posts/" + photo.post_image
                    );
                    let post_gellary_url = "";
                    photo.post_gallery.forEach(function (gallery) {
                        post_gellary_url +=
                            '<img class="shadow" style="width: 150px; margin-right: 10px" src="/media/posts/' +
                            gallery +
                            '" />';
                    });
                    $(".post_gallery_image").html(post_gellary_url);

                    $(".post_audio").val(photo.post_audio);
                    $(".post_video").val(photo.post_video);

                    postType(data.post_type);

                    $("#edit_post_modal").modal("show");
                },
            });

        });


        //Add featured post script /select post format script
        let format = $("#post_format")
            .children("option:selected")
            .val();
        if (format == "Image") {
            $(".post_image").show();
        } else {
            $(".post_image").hide();
        }
        if (format == "Gallery") {
            $(".post_image_g").show();
        } else {
            $(".post_image_g").hide();
        }

        if (format == "Audio") {
            $(".post_image_a").show();
        } else {
            $(".post_image_a").hide();
        }

        if (format == "Video") {
            $(".post_image_v").show();
        } else {
            $(".post_image_v").hide();
        }


        //Edit featured post script /select post format script
        let e_format = $("#edit_post_format")
            .children("option:selected")
            .val();
        if (e_format == "Image") {
            $(".post_image").show();
        } else {
            $(".post_image").hide();
        }
        if (e_format == "Gallery") {
            $(".post_image_g").show();
        } else {
            $(".post_image_g").hide();
        }

        if (e_format == "Audio") {
            $(".post_image_a").show();
        } else {
            $(".post_image_a").hide();
        }

        if (e_format == "Video") {
            $(".post_image_v").show();
        } else {
            $(".post_image_v").hide();
        }


        // post update by ajax
        $(document).on('submit', '#edit_post_form', function (e) {
            e.preventDefault();
            let title = $(".p_title").val();
            // console.log(name + " " + parent_id);

            if (title == "" || title == null) {
                $.notify('Post title is required!', {
                    globalPosition: "top right",
                    className: "error"
                });
            } else {
                // data pass by ckeditor
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                            "content"
                        ),
                    },
                    url: '/posts/post-edit-store',
                    method: "POST",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        // console.log(data);

                        $.notify(data.success, {
                            globalPosition: 'top right',
                            className: 'success'
                        });

                        $('#post_table').DataTable().ajax.reload();
                        $('#post_trash_table').DataTable().ajax.reload();
                        $('#edit_post_modal').modal('hide');

                    },

                });

            }

        });

        // single post preview
        $(document).on("click", ".preview_post", function (e) {
            e.preventDefault();
            let preview_id = $(this).attr("preview_id");

            $.ajax({
                url: "/posts/post-list/" + preview_id,
                type: "GET",
                success: function (data) {
                    if (data.post_type != "") {
                        $("#p_type").show();
                        $("#post_details_modal #post_type").html(
                            data.post_type
                        );
                    } else {
                        $("#p_type").hide();
                    }

                    if (data.title != "") {
                        $("#p_t").show();
                        $("#post_details_modal #post_title").html(data.title);
                    } else {
                        $("#p_t").hide();
                    }

                    if (data.slug != "") {
                        $("#p_s").show();
                        $("#post_details_modal #post_slug").html(data.slug);
                    } else {
                        $("#p_s").hide();
                    }

                    if (data.categories != "") {
                        $("#p_c").show();
                        for (const category of data.categories) {
                            $("#post_details_modal #post_category").append(
                                "" +
                                    '<span class="select_category">' +
                                    category["name"] +
                                    "," +
                                    " " +
                                    "</span>"
                            );
                        }
                    } else {
                        $("#p_c").hide();
                    }

                    if (data.tags != "") {
                        $("#p_tag").show();
                        for (const tag of data.tags) {
                            $("#post_details_modal #post_tag").append(
                                "" +
                                    '<span class="select_tag">' +
                                    tag["name"] +
                                    "," +
                                    " " +
                                    "</span>"
                            );
                        }
                    } else {
                        $("#p_tag").hide();
                    }

                    if (data.status != "") {
                        $("#p_sta").show();
                        $("#post_details_modal #post_status").html(data.status);
                    } else {
                        $("#p_sta").hide();
                    }

                    if (data.description != "") {
                        $("#p_con").show();
                        $("#post_details_modal #post_content").html(
                            data.description
                        );
                    } else {
                        $("#p_con").hide();
                    }

                    if (data.post_image != "") {
                        $("#p_i").show();
                        $("#post_details_modal #post_image img").attr(
                            "src",
                            "/media/posts/" + data.post_image
                        );
                    } else {
                        $("#p_i").hide();
                    }

                    if (data.post_gallery != "") {
                        $("#p_g").show();
                        for (const gallery of data.post_gallery) {
                            $("#post_details_modal #post_g_image").append(
                                "" +
                                    '<span class="gallery_image"><img width="150" style="margin: 5px;" src="/media/posts/' +
                                    gallery +
                                    '" alt=""></span>'
                            );
                        }
                    } else {
                        $("#p_g").hide();
                    }

                    if (data.post_audio != null && data.post_audio != "") {
                        $("#p_a").show();
                        $("#post_details_modal #post_audio").append(
                            "" +
                                '<span class="p_audio"><iframe width="400" height="250" src="' +
                                data.post_audio +
                                '" frameborder="0"></iframe></span>'
                        );
                    } else {
                        $("#p_a").hide();
                    }

                    if (data.post_video != null && data.post_video != "") {
                        $("#p_v").show();
                        $("#post_details_modal #post_video").append(
                            "" +
                                '<span class="p_video"><iframe width="400" height="250" src="' +
                                data.post_video +
                                '" frameborder="0"></iframe></span>'
                        );
                    } else {
                        $("#p_v").hide();
                    }

                    $("#post_details_modal").modal("show");
                },
            });
        });

        // single post gallery image and category and tag problem solve
        $(document).on("click", "#remove_gallary_image", function (event) {
            event.preventDefault();
            $(".gallery_image").remove();
            $(".p_video").remove();
            $(".p_audio").remove();
            $(".select_category").remove();
            $(".select_tag").remove();
        });


        //post Status update
        $(document).on("change", "input.post_status_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();
            // alert(id);

            $.ajax({
                url: "/posts/post-status-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#post_table').DataTable().ajax.reload();
                    $('#post_trash_table').DataTable().ajax.reload();

                }
            });

        });


        //post trash update
        $(document).on("change", "input.post_trash_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();

            // alert(id);

            $.ajax({
                url: "/posts/post-trash-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#post_table').DataTable().ajax.reload();
                    $('#post_trash_table').DataTable().ajax.reload();

                }
            });
        });


        //post thumbnail update
        $(document).on("change", "input.post_thumbnail_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();

            // alert(id);

            $.ajax({
                url: "/posts/post-thumbnail-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#post_table').DataTable().ajax.reload();
                    $('#post_trash_table').DataTable().ajax.reload();

                }
            });
        });

        // post delete
        $(document).on('submit', '#post_delete_form', function (e) {
            e.preventDefault();
            let id = $('#delete_post').val();
            // alert(id);

            swal(
                {
                    title: "Are you sure?",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                    "content"
                                ),
                            },
                            url: '/posts/delete',
                            method: 'POST',
                            data: { id: id },
                            success: function (data) {
                                swal(
                                    {
                                        title: "Deleted!",
                                        type: "success"
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            $.notify(data.success, {
                                                globalPosition: "top right",
                                                className: 'success'
                                            });
                                            // console.log(data);

                                            $('#post_table').DataTable().ajax.reload();
                                            $('#post_trash_table').DataTable().ajax.reload();
                                        }
                                    }
                                );
                            }
                        });

                    } else {
                        swal("Cancelled", "", "error");
                    }
                }
            );


        });


        //================= Logos ================//

        //logos Table load by yijra datatable
        $('#logo_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/logos/logo-list'
            },
            columns: [
                {
                    data: 'languages.name',
                    name: 'languages.name'
                },
                {
                    data: 'logo',
                    name: 'logo',
                    render: function (data, type, full, meta) {
                        return `<img class="logo_image_list" src="/media/logos/${data}" alt="">`;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input logo_status_update" id="customSwitchLogoShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchLogoShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input logo_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        //logo Trash Table load by yijra datatable
        $('#logo_trash_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/logos/logo-trash-list'
            },
            columns: [
                {
                    data: 'languages.name',
                    name: 'languages.name'
                },
                {
                    data: 'logo',
                    name: 'logo',
                    render: function (data, type, full, meta) {
                        return `<img class="logo_image_list" src="/media/logos/${data}" alt="">`;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input logo_status_update" id="customSwitchLogoShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchLogoShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input logo_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });


        // Logo add by ajax
        $(document).on('submit', '#logo_add_form', function (e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/logos/logo-list',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {

                    $.notify(data.success, {
                        globalPosition: "top right",
                        className: "success"
                    });
                    $('#logo_add_form')[0].reset();
                    $('#add_logo_modal').modal('hide');
                    $('#logo_table').DataTable().ajax.reload();
                }
            });
        });

        // Logo edit data show modal admin purpose
        $(document).on("click", ".edit_logo_data", function (e) {
            e.preventDefault();
            let edit_id = $(this).attr("edit_id");
            // alert(edit_id);

            $.ajax({
                url: "/logos/logo-list/" + edit_id + '/edit',
                type: "GET",
                success: function (data) {
                    // console.log(data);
                    $('.logo_id').val(data.id);
                    $(".language_id").val(data.language_id);
                    $(".l_logo_load_val").attr(
                        "src",
                        "/media/logos/" + data.logo
                    );
                    $(".l_logo_load_show").attr(
                        "src",
                        "/media/logos/" + data.logo
                    );

                    $("#edit_logo_modal").modal("show");
                },
            });
        });

        //Logo add image load
        $(document).on("change", "#logo_add_file", function (e) {
            e.preventDefault();
            let image_url = URL.createObjectURL(e.target.files[0]);
            $("#logo_add_load_photo").attr("src", image_url);
        });

        //Logo edit image load
        $(document).on("change", "#logo_file", function (e) {
            e.preventDefault();
            let image_url = URL.createObjectURL(e.target.files[0]);
            $("#logo_load_photo").attr("src", image_url);
        });


        // logo update by ajax
        $(document).on('submit', '#edit_logo_form', function (e) {
            e.preventDefault();
            let id = $('.logo_id').val();

            // alert(id);

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/logos/logo-edit-store',
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {

                    $.notify(data.success, {
                        globalPosition: 'top right',
                        className: 'success'
                    });
                    // console.log(data);

                    $('#logo_table').DataTable().ajax.reload();
                    $('#logo_trash_table').DataTable().ajax.reload();
                    $('#edit_logo_modal').modal('hide');

                },

            });

        });


        //Logo Status update
        $(document).on("change", "input.logo_status_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();
            // alert(value);

            $.ajax({
                url: "/logos/logo-status-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#logo_table').DataTable().ajax.reload();
                    $('#logo_trash_table').DataTable().ajax.reload();

                }
            });

        });


        //Logo trash update
        $(document).on("change", "input.logo_trash_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();

            // alert(id);

            $.ajax({
                url: "/logos/logo-trash-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#logo_table').DataTable().ajax.reload();
                    $('#logo_trash_table').DataTable().ajax.reload();

                }
            });
        });

        // Logo delete
        $(document).on('submit', '#logo_delete_form', function (e) {
            e.preventDefault();
            let id = $('#delete_logo').val();
            // alert(id);

            swal(
                {
                    title: "Are you sure?",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                    "content"
                                ),
                            },
                            url: '/logos/delete',
                            method: 'POST',
                            data: { id: id },
                            success: function (data) {
                                swal(
                                    {
                                        title: "Deleted!",
                                        type: "success"
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            $.notify(data, {
                                                globalPosition: "top right",
                                                className: 'success'
                                            });


                                            $('#logo_table').DataTable().ajax.reload();
                                            $('#logo_trash_table').DataTable().ajax.reload();
                                        }
                                    }
                                );
                            }
                        });

                    } else {
                        swal("Cancelled", "", "error");
                    }
                }
            );


        });


        //================= Favicon ================//

        //favicon Table load by yijra datatable
        $('#favicon_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/favicons/favicon-list'
            },
            columns: [
                {
                    data: 'languages.name',
                    name: 'languages.name'
                },
                {
                    data: 'favicon',
                    name: 'favicon',
                    render: function (data, type, full, meta) {
                        return `<img class="logo_image_list" src="/media/favicons/${data}" alt="">`;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input favicon_status_update" id="customSwitchLogoShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchLogoShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input favicon_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        //favicon Trash Table load by yijra datatable
        $('#favicon_trash_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/favicons/favicon-trash-list'
            },
            columns: [
                {
                    data: 'languages.name',
                    name: 'languages.name'
                },
                {
                    data: 'favicon',
                    name: 'favicon',
                    render: function (data, type, full, meta) {
                        return `<img class="logo_image_list" src="/media/favicons/${data}" alt="">`;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input favicon_status_update" id="customSwitchLogoShadow${full.id}" ${full.status == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchLogoShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'trash',
                    name: 'trash',
                    render: function (data, type, full, meta) {
                        return `

                            <div class="custom-control custom-switch custom-switch-shadow custom-control-inline">
                                <input type="checkbox" data_id="${full.id}" class="custom-control-input favicon_trash_update" id="customSwitchTrashShadow${full.id}" ${full.trash == true ? 'checked="checked"' : ''} value="${data}">
                                <label class="custom-control-label" for="customSwitchTrashShadow${full.id}">
                                </label>
                            </div>

                            `;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });


        // Favicon add by ajax
        $(document).on('submit', '#favicon_add_form', function (e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/favicons/favicon-list',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {

                    $.notify(data.success, {
                        globalPosition: "top right",
                        className: "success"
                    });
                    $('#favicon_add_form')[0].reset();
                    $('#add_favicon_modal').modal('hide');
                    $('#favicon_table').DataTable().ajax.reload();
                }
            });
        });

        // Favicon edit data show modal admin purpose
        $(document).on("click", ".edit_favicon_data", function (e) {
            e.preventDefault();
            let edit_id = $(this).attr("edit_id");
            // alert(edit_id);

            $.ajax({
                url: "/favicons/favicon-list/" + edit_id + '/edit',
                type: "GET",
                success: function (data) {
                    // console.log(data);
                    $('.favicon_id').val(data.id);
                    $(".language_id").val(data.language_id);
                    $(".favicon_load_val").attr(
                        "src",
                        "/media/favicons/" + data.favicon
                    );
                    $(".favicon_load_show").attr(
                        "src",
                        "/media/favicons/" + data.favicon
                    );

                    $("#edit_favicon_modal").modal("show");
                },
            });
        });

        //Favicon add image load
        $(document).on("change", "#favicon_add_file", function (e) {
            e.preventDefault();
            let image_url = URL.createObjectURL(e.target.files[0]);
            $("#favicon_add_load_photo").attr("src", image_url);
        });

        //Favicon edit image load
        $(document).on("change", "#favicon_file", function (e) {
            e.preventDefault();
            let image_url = URL.createObjectURL(e.target.files[0]);
            $("#favicon_load_photo").attr("src", image_url);
        });


        // Favicon update by ajax
        $(document).on('submit', '#edit_favicon_form', function (e) {
            e.preventDefault();
            let id = $('.favicon_id').val();

            // alert(id);

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                        "content"
                    ),
                },
                url: '/favicons/edit-updte',
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {

                    $.notify(data.success, {
                        globalPosition: 'top right',
                        className: 'success'
                    });
                    // console.log(data);

                    $('#favicon_table').DataTable().ajax.reload();
                    $('#favicon_trash_table').DataTable().ajax.reload();
                    $('#edit_favicon_modal').modal('hide');

                },

            });

        });

        $('#add_favicon_modal').modal('hide');

        //Favicon Status update
        $(document).on("change", "input.favicon_status_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();
            // alert(value);

            $.ajax({
                url: "/favicons/favicon-status-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#favicon_table').DataTable().ajax.reload();
                    $('#favicon_trash_table').DataTable().ajax.reload();

                }
            });

        });


        //Favicon trash update
        $(document).on("change", "input.favicon_trash_update", function () {
            let id = $(this).attr("data_id");
            let value = $(this).val();

            // alert(id);

            $.ajax({
                url: "/favicons/favicon-trash-update/" + id + '/' + value,
                success: function (data) {
                    $.notify(data, {
                        globalPosition: "top right",
                        className: "success"
                    });

                    $('#favicon_table').DataTable().ajax.reload();
                    $('#favicon_trash_table').DataTable().ajax.reload();

                }
            });
        });

        // Favicon delete
        $(document).on('submit', '#favicon_delete_form', function (e) {
            e.preventDefault();
            let id = $('#delete_favicon').val();
            // alert(id);

            swal(
                {
                    title: "Are you sure?",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr(
                                    "content"
                                ),
                            },
                            url: '/favicons/delete',
                            method: 'POST',
                            data: { id: id },
                            success: function (data) {
                                swal(
                                    {
                                        title: "Deleted!",
                                        type: "success"
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            $.notify(data, {
                                                globalPosition: "top right",
                                                className: 'success'
                                            });


                                            $('#favicon_table').DataTable().ajax.reload();
                                            $('#favicon_trash_table').DataTable().ajax.reload();
                                        }
                                    }
                                );
                            }
                        });

                    } else {
                        swal("Cancelled", "", "error");
                    }
                }
            );


        });



    });
})(jQuery);
