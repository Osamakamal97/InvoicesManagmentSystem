<script src="{{ asset('js/app.js') }}"></script>
<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
<script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/ionicons/ionicons.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>
<!-- Rating js-->
<script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{URL::asset('assets/plugins/rating/jquery.barrating.js')}}"></script>
<!--Internal  Perfect-scrollbar js -->
<script src="{{URL::asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>
<!--Internal Sparkline js -->
<script src="{{URL::asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- right-sidebar js -->
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-rtl.js')}}"></script>
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>
<!-- Eva-icons js -->
<script src="{{URL::asset('assets/js/eva-icons.min.js')}}"></script>
@yield('js')
<!-- Sticky js -->
<script src="{{URL::asset('assets/js/sticky.js')}}"></script>
<!-- custom js -->
<script src="{{URL::asset('assets/js/custom.js')}}"></script><!-- Left-menu js-->
<script src="{{URL::asset('assets/plugins/side-menu/sidemenu.js')}}"></script>
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
@livewireScripts
{{-- <script>
    Echo.private('events')
        .listen('RealTimeMessage', (e) => console.log('Private RealTimeMessage: ' + e.message));

</script> --}}
@if (auth()->check())
<script>
    Echo.private('App.Models.User.{{ auth()->user()->id }}')
        .notification((notification) => {
            // console.log('notification: '+notification);
            // pulse when new notification
            document.getElementById('notification_pulse').style.display = '';
            // Increase number of notifications by one
            let notifications_count = document.getElementById('notifications_count');
            notifications_count.textContent = parseInt(notifications_count.innerText) + 1;
            // Add notifications
            // let unread_notifications = document.querySelector('#unread_notifications');
            // const date = new Date();
            // seconds = seconds-(days*24*60*60)-(hours*60*60)-(minutes*60);
            // const seconds =  $("#time_from").text(seconds);
            //             },1000);
            // var myVar = setInterval(myTimer, 1000);
            var d = new Date().getMinutes().toString();

            $(".main-notification-list").append(`<a class='d-flex p-3 border-bottom' id='notification_id' href='{{ url('invoice/${notification.invoice_id}/details') }}'>`
                +`<div class='mr-3'>`
                +`<h5 class='notification-label mb-1'> ${notification.title}: ${notification.user} </h5>`
                +`<div class='notification-subtext' id='time_from'>${d}</div></div><div class='mr-auto'></div></a>`);

                var today = new Date();

                var myVar = setInterval(myTimer, 5000);

                function myTimer() {
                    let d = new Date();
                    var diffMs = (d - today);
                    var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
                    document.getElementById("time_from").innerHTML = "منذ " + diffMins + " دقيقة";
                    console.log(diffMins);

                }

                // function myTimer() {
                //     var d = new Date().getMinutes();
                //     document.getElementById("time_from").innerHTML = d.toLocaleTimeString();
                // }
    });
</script>
<script>

    // var totalMinutes = $('.totalMin').html();

    // var hours = Math.floor(totalMinutes / 60);          
    // var minutes = 1 % 60;

    // $('.convertedHour').html(hours);
    // $('.convertedMin').html(minutes);    

    // var today = new Date();

    // var myVar = setInterval(myTimer(today), 5000);

    // function myTimer(today) {
    //     let d = new Date();
    //     var diffMs = (d - today);
    //     var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
    //     document.getElementById("time_from").innerHTML = diffMins;
    //     console.log(diffMins);

    // }
</script>
{{-- <script>
    $(".main-notification-list").append(`<a class='d-flex p-3 border-bottom' id='notification_id' href='#'>`
                +`<div class='mr-3'>`
                +`<h5 class='notification-label mb-1'> ldksjfkldsfjslkafjl;askfd</h5>`
                +`<div class='notification-subtext'>asdadadasd</div></div><div class='mr-auto'></div></a>`);
    $(".main-notification-list").append(`<a class='d-flex p-3 border-bottom' id='notification_id' href='#'>`
                +`<div class='mr-3'>`
                +`<h5 class='notification-label mb-1'> ldksjfkldsfjslkafjl;askfd</h5>`
                +`<div class='notification-subtext'>asdadadasd</div></div><div class='mr-auto'></div></a>`);
    $(".main-notification-list").append(`<a class='d-flex p-3 border-bottom' id='notification_id' href='#'>`
                +`<div class='mr-3'>`
                +`<h5 class='notification-label mb-1'> ldksjfkldsfjslkafjl;askfd</h5>`
                +`<div class='notification-subtext'>asdadadasd</div></div><div class='mr-auto'></div></a>`);
</script> --}}
@endif