@if(session()->has('response'))
    <div class="alert alert-success">
        {{ session()->get('response') }}
    </div>
@endif