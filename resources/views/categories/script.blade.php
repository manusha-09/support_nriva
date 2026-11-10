
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>

<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>

<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>

<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- <script src="{{asset('dist/js/support.js')}}"></script> -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script type="text/javascript">
     $(document).ready(function() {
    $("input[id^='upload_file']").each(function() {
    var id = parseInt(this.id.replace("upload_file", ""));
    $("#upload_file" + id).change(function() {
    if ($("#upload_file" + id).val() != "") {
    $("#moreImageUploadLink").show();
    }
    });
     });
    });
     $(document).ready(function() {
     var upload_number = 2;
    $('#attachMore').click(function() {
    //add more file
    var moreUploadTag = '';
    moreUploadTag += '<div class="element form-group row"><label class="col-sm-4 col-form-label" for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>';
    moreUploadTag += '<input type="file" name="files[]"  class="col-sm-6 form-control-file pl-3"/>';
    moreUploadTag += ' <div class="col-lg-2 px-0"><a class="btn btn-danger" href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;">Delete </a></div></div>';
    $('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload');
    upload_number++;
      });
    });

 function del_file(eleId) {
  var ele = document.getElementById("delete_file" + eleId);
  ele.parentNode.removeChild(ele);
}
</script>

