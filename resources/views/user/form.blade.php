<form method="POST" action="{{ route($routePath.'.store') }}" role="form" enctype="multipart/form-data">
    {{ method_field('POST') }}
    @csrf
    <div class="form-group">
        {{ Form::label('name') }}
        {{ Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name', 'required']) }}
        {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
    </div>
    <div class="form-group">
        {{ Form::label('username') }}
        {{ Form::text('username', null, ['class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : ''), 'placeholder' => 'Username', 'required']) }}
        {!! $errors->first('username', '<div class="invalid-feedback">:message</p>') !!}
    </div>
    <div class="form-group">
        {{ Form::label('Password') }}
        {{ Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => 'Password']) }}
        {!! $errors->first('password', '<div class="invalid-feedback">:message</p>') !!}
    </div>
    <div class="form-group">
        {{ Form::label('email') }}
        {{ Form::text('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email', 'required']) }}
        {!! $errors->first('email', '<div class="invalid-feedback">:message</p>') !!}
    </div>
    <div class="form-group">
        {{ Form::label('role') }}
        {!! Form::select('roles', $roles, null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>