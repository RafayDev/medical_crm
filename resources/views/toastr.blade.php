<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
// Set the options that I want
toastr.options = {
  "closeButton": true,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}


  // success message popup notification
  @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
  @endif

  // info message popup notification
  @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
  @endif

  // warning message popup notification
  @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
  @endif

  // error message popup notification
  @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
  @endif
  

</script>