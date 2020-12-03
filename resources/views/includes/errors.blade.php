@if($errors->any())

	@dd($errors)
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>


@endif
