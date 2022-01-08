 <!-- BEGIN: Vendor JS-->
 <script src="{{ asset('backend/') }}/app-assets/vendors/js/vendors.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
 <!-- BEGIN Vendor JS-->

 <!-- BEGIN: Page Vendor JS-->
 <script src="{{ asset('backend/') }}/app-assets/vendors/js/charts/apexcharts.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/vendors/js/extensions/swiper.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('backend/assets/plugins')}}/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('backend/assets/plugins')}}/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('backend/assets/plugins')}}/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('backend/assets/plugins')}}/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('backend/assets/plugins')}}/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('backend/assets/plugins')}}/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('backend/assets/plugins')}}/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('backend/assets/plugins')}}/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('backend/assets/plugins')}}/datatables-buttons/js/buttons.colVis.min.js"></script>
 <!-- END: Page Vendor JS-->

 <!-- BEGIN: Theme JS-->
 <script src="{{ asset('backend/') }}/app-assets/js/scripts/configs/vertical-menu-light.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/js/core/app-menu.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/js/core/app.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/js/scripts/components.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/js/scripts/footer.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/js/scripts/customizer.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/js/scripts/notify.js"></script>
 <script src="//cdn.ckeditor.com/4.16.1/full/ckeditor.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/js/scripts/forms/select/form-select2.min.js"></script>
 <script src="{{ asset('backend/') }}/app-assets/js/dropify.min.js"></script>
 {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
 <!-- END: Theme JS-->

 <!-- Icon Picker -->
<script src="{{ asset('backend/assets/dist/') }}/js/bootstrap-iconpicker.bundle.min.js"></script>
<script src="{{ asset('backend/assets/dist/') }}/js/bootstrap-iconpicker.js"></script>
<script src="{{ asset('backend/assets/dist/') }}/js/bootstrap-iconpicker.min.js"></script>
<script src="{{ asset('backend/assets/dist/') }}/js/bootstrap-iconpicker-iconset-all.js"></script>
<script src="{{ asset('backend/assets/dist/') }}/js/bootstrap-iconpicker-iconset-all.min.js"></script>

 <script src="{{ asset('backend/') }}/app-assets/js/scripts/datatables/datatable.min.js"></script>

 <script src="{{ asset('backend/') }}/app-assets/js/all.min.js"></script>
 {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-fzff82+8pzHnwA1mQ0dzz9/E0B+ZRizq08yZfya66INZBz86qKTCt9MLU0NCNIgaMJCgeyhujhasnFUsYMsi0Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

 <script src="{{ asset('backend/') }}/app-assets/js/custom/custom.js"></script>

 <script>
     $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        //   $('#example2').DataTable({
        //     "paging": true,
        //     "lengthChange": false,
        //     "searching": false,
        //     "ordering": true,
        //     "info": true,
        //     "autoWidth": false,
        //     "responsive": true,
        //   });
 </script>



 <!-- notify -->
@if(session()->has('success'))
    <script text="text/javascript">
        $(function(){
            $.notify("{{session()->get('success')}}", {globalPosition: 'top right', className:'success'});
        });
    </script>
@endif
@if(session()->has('error'))
    <script text="text/javascript">
        $(function(){
            $.notify("{{session()->get('error')}}", {globalPosition: 'top right', className:'error'});
        });
    </script>
@endif
@if(session()->has('warning'))
    <script text="text/javascript">
        $(function(){
            $.notify("{{session()->get('warning')}}", {globalPosition: 'top right', className:'warning'});
        });
    </script>
@endif
