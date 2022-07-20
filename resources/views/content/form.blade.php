<form method="POST" action="{{ route($routePath . '.store') }}" role="form" enctype="multipart/form-data">
    {{ method_field('POST') }}
    @csrf
    <div class="form-group">
        {{ Form::label('Category') }}
        {{ Form::select('content_category_id', $contentCategories, null, ['class' => 'form-control' . ($errors->has('content_category_id') ? ' is-invalid' : ''), 'placeholder' => 'Category', 'required']) }}
        {!! $errors->first('content_category_id', '<div class="invalid-feedback">:message</p>') !!}
    </div>
    <div class="form-group">
        {{ Form::label('title') }}
        {{ Form::text('title', null, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => 'Title', 'required']) }}
        {!! $errors->first('title', '<div class="invalid-feedback">:message</p>') !!}
    </div>
    <div class="form-group">
        {{ Form::label('body') }}
        {{ Form::textarea('body', null, ['class' => 'form-control' . ($errors->has('body') ? ' is-invalid' : ''), 'placeholder' => 'Body']) }}
        {!! $errors->first('body', '<div class="invalid-feedback">:message</p>') !!}
    </div>
    <div class="form-group">
        {{ Form::label('file') }}
        {{ Form::file('file', ['class' => 'form-control' . ($errors->has('file') ? ' is-invalid' : '')]) }}
        {!! $errors->first('file', '<div class="invalid-feedback">:message</p>') !!}
        {{-- @if (!empty($content->file))
            <img src="/{{ $content->file_dir }}/{{ $content->file }}" width="300">
        @endif --}}
    </div>
    {{-- <div class="form-group">
    {{ Form::label('extra') }}
    {{ Form::text('extra', null, ['class' => 'form-control' . ($errors->has('extra') ? ' is-invalid' : ''), 'placeholder' => 'Extra', 'required']) }}
    {!! $errors->first('extra', '<div class="invalid-feedback">:message</p>') !!}
</div> --}}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
