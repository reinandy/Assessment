<form method="POST" action="{{ route($routePath.'.store') }}"  role="form" enctype="multipart/form-data">
    {{ method_field('POST') }}
    @csrf
        <div class="form-group">
            {{ Form::label('name') }}
            {{ Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name', 'required']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
</form>