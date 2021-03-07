@if(session('statuss_'))
<div class="alert alert-success">
	{{ session('statuss_') }}
</div>
@endif

@if(session('errores_'))
<div class="alert alert-danger">
	{{ session('errores_') }}
</div>
@endif
