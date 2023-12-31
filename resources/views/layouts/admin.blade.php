<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    .box {
        border: 1px solid #ccc;
        border-radius: 15px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .box-body {
        padding: 10px;
        text-align: center;
    }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artema</title>
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('frontend/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('frontend\css\fontawesome\css\all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
        @include('layouts.sidebar')
        <div class="content">
            @include('layouts.header')
            <div class="container-fluid">
                @include('toastr')
                @yield('content')
            </div>
            @include('layouts.footer')

        </div>
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('frontend/lib/chart/chart.min.js')}}"></script>
    <script src="{{asset('frontend/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('frontend/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('frontend/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('frontend/lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('frontend/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('frontend/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('frontend/js/main.js')}}"></script>
</body>
@yield('scripts')
<script>
//get unread notifications
// Check if the lastNotificationCount is in localStorage or initialize to 0
let lastNotificationCount = localStorage.getItem('lastNotificationCount') || 0;

//get unread notifications
function get_unread_notifications() {
    $.ajax({
        url: "{{route('notifications')}}",
        type: "GET",
        success: function(response) {
            $('#notification-list').html(response.html);
            
            // Extract the new notification count from the response
            let newNotificationCount = parseInt($(response.notification_count).text());

            if (newNotificationCount > lastNotificationCount) {
                // There are new notifications, show the toast
                toastr.info('You have ' + newNotificationCount + ' new notifications');
                
                // Update the lastNotificationCount in both the variable and localStorage
                lastNotificationCount = newNotificationCount;
                localStorage.setItem('lastNotificationCount', lastNotificationCount);
            }

            $('#notification-count').html(response.notification_count);
        }
    });
}

get_unread_notifications();
get_cart_count();
setInterval(function() {
    get_unread_notifications();
    get_cart_count();
}, 5000);
// Assuming you have a button/link with the id 'mark-as-read'
$(document).on('click', '#mark-as-read', function(e) {
    e.preventDefault();  // prevent default action if it's a link or submit button
    // Make an AJAX call to mark all as read
    $.ajax({
        url: "{{ route('mark-as-read') }}",  // Adjust this to your actual route
        type: "Get",  // Or whatever your method is
        success: function(response) {
            // Update the lastNotificationCount in both the variable and localStorage
            lastNotificationCount = 0;
            localStorage.setItem('lastNotificationCount', 0);
            get_unread_notifications();
        }
    });
    
});
function get_cart_count() {
    $.ajax({
        url: "{{route('cart-count')}}",
        type: "GET",
        success: function(response) {
            $('#cart-count').html(response);
        }
    });
}

</script>

</html>