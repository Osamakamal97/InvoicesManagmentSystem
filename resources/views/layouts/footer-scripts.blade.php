<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- WebSocket required js -->
<script src="{{ asset('js/app.js') }}"></script>
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
<script>
     var myItems = new PerfectScrollbar(".Notification-scroll", {
                                wheelPropagation: true
                            });
            // $('.Notification-scroll').perfectScrollbar('update');
            // $('myItems').perfectScrollbar('update');
</script>
@if (auth()->check())
<script>
    Echo.private('App.Models.User.{{ auth()->user()->id }}')
        .notification((notification) => {
            // pulse when new notification
            document.getElementById('notification_pulse').style.display = '';
            // Increase number of notifications by one
            let notifications_count = document.getElementById('notifications_count');
            notifications_count.textContent = parseInt(notifications_count.innerText) + 1;
            // Add notifications
            var d = new Date().getMinutes().toString();
            $(".main-notification-list").prepend(`<a class='d-flex p-3 border-bottom' id='notification_id' href='{{ url('invoice/${notification.invoice_id}/details') }}'>`
                +`<div class='mr-3'>`
                +`<h5 class='notification-label mb-1'> ${notification.title}: ${notification.user} </h5>`
                +`<div class='notification-subtext' id='time_from'>${d}</div></div><div class='mr-auto'></div></a>`);

            var today = new Date();
            // Update time every 5 seconds for real time notifications
            var myVar = setInterval(myTimer, 5000);
            // Get the diffirent between time that notification is notify and now time
            function myTimer() {
                let now = new Date();
                var diffMs = (now - today);
                var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
                document.getElementById("time_from").innerHTML = "منذ " + diffMins + " دقيقة";
            }

        });
</script>
@endif
