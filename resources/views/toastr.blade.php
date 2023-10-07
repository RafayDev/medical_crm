<div class="position-absolute w-100 p-4 d-flex flex-column align-items-end" style="z-index: 1000000000000">
    <div class="w-25">


        <!-- Then put toasts within -->
        <div class="toast" id="success_toast" role="status" aria-live="polite" aria-atomic="true" data-delay=3000 style="z-index: 1000000000">
            <div class="toast-header">
                <svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                    <rect width="100%" height="100%" fill="green"></rect>
                </svg>
                <strong class="mr-auto">Success</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">

            </div>
        </div>
    </div>
</div>
<script>
      @if(Session::has('success'))
            $('#success_toast .toast-body').html('{{Session::get('success')}}');
            $('#success_toast').toast('show');
      @endif

</script>