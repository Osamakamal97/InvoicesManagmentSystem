{{-- @if (session()->has('success'))
<div class="alert alert-success">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    {{ session()->get('success') }}
</div>
@elseif (session()->has('error'))
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    {{ session()->get('error') }}
</div>
@endif --}}
{{-- notfiy --}}
@if (session()->has('success'))
<script>
    window.addEventListener('load', getNotification);
     function getNotification(){
        console.log('hello');
        notif({
            type: "success",
            msg: "{{ session()->get('success') }}",
            position: "right",
            bottom:'10'
        });
    }
</script>
{{-- <button onclick="not6()" class="btn btn-primary mg-t-5">Primary</button> --}}
@elseif (session()->has('error'))
<script>
    window.addEventListener('load', getNotification);
     function getNotification(){
        console.log('hello');
        notif({
            type: "error",
            msg: "{{ session()->get('error') }}",
            position: "right",
            bottom:'10'
        });
    }
</script>
@endif
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


