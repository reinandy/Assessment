@extends('layout.default')
@section('content')
    <style>
        .bg-transparent {
            background-color: transparent !important;
        }
    </style>
    @can('content-read')
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 mb-5">
                        <img src="{{ '/' . $contents->file_dir . '/' . $contents->file }}" class="rounded" width="100%">
                        <div class="d-flex justify-content-between mt-5">
                            <h3 class="card-title text-dark">{{ $contents->title }}</h3>
                            <div class="text-dark text-right">{{ $contents->created_at->format('d M Y') }}</div>
                        </div>
                        <p>{{ $contents->body }}</p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="btn btn-secondary btn-sm">{{ $contents->contentCategory->name }}</div>
                            </div>
                            <div class="text-right d-flex">
                                @if (auth()->user()->id == $contents->created_by)
                                    @can('content-delete')
                                        <form action="{{ route('contents.destroy', $contents->id) }}" method="POST" class="mr-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-delete">Delete your article</button>
                                        </form>
                                    @endcan
                                    @can('content-edit')
                                        <a href="{{ route('contents.edit', $contents->id) }}" class="btn btn-primary btn-sm">Edit your
                                            article</a>
                                    @endcan
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="card-title text-dark my-5 pt-5">Recomendation for you</h3>
                <div class="row" id="content">
                    @foreach ($recomContents as $v)
                        <a href="{{ route('detail', $v->id) }}" class="col-md-6 mb-5 searchable">
                            <div class="card round bg-transparent">
                                <img class="card-img-top rounded" src="{{ '/' . $v->file_dir . '/' . $v->file }}"
                                    height="250">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="card-title text-dark">{{ $v->title }}</h4>
                                        <div class="text-dark text-right">{{ $v->created_at->format('d M Y') }}</div>
                                    </div>
                                    <p class="card-text text-dark">{{ substr($v->body, 0, 150) }}...</p>
                                    <div class="btn btn-secondary btn-sm">{{ $v->contentCategory->name }}</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                @if (count($myContents))
                    <h3 class="mb-5"><b>Your Article</b></h3>
                    <div class="row">
                        @foreach ($myContents as $v)
                            <a href="{{ route('detail', $v->id) }}" class="col-md-12 mb-5">
                                <div class="d-flex">
                                    <div class="w-25">
                                        <img src="{{ '/' . $v->file_dir . '/' . $v->file }}" class="rounded" width="100%">
                                    </div>
                                    <div class="w-75">
                                        <div class="ml-3">
                                            <b class="text-dark">{{ $v->title }}</b>
                                            <div class="text-dark">{{ substr($v->body, 0, 50) }}...</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
                <h3 class="mb-5"><b>All Categories</b></h3>
                <div class="row">
                    @foreach ($contentCategories as $i)
                        <div class="col-md-6 mb-5">
                            <button class="btn btn-secondary btn-sm btn-block btn-categories"
                                data-val="{{ $i }}">{{ $i }}</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endcan
@endsection
@section('scripts')
    <script>
        $('body').on('click', '.btn-delete', function(event) {
            event.preventDefault();

            var form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: form.attr('method'),
                        url: form.attr('action'),
                        data: form.serialize(),
                        success: function(r) {
                            Swal.fire({
                                icon: 'success',
                                title: r.message
                            });

                            window.location.href = "{{ route('dashboard') }}";
                        },
                        error: function(e) {
                            Swal.fire({
                                icon: 'error',
                                title: 'An error occurred.'
                            });
                        },
                    });
                }
            })
        });
    </script>
@endsection
