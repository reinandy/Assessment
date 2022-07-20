        
        <div class="form-group">
            {{ Form::label('name') }}
            {{ Form::text('name', $contentCategory->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name', 'required']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>