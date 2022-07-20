@extends('layout.default')
@section('content')
    @can('content-read')
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 mb-5">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control search" placeholder="Search article ...">
                            </div>
                            <div class="col-md-3">
                                <select class="form-control search" id="c-search">
                                    <option value="">Categories</option>
                                    @foreach ($contentCategories as $i)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                @can('content-create')
                                    <a href="{{ route('contents.create') }}" class="btn btn-primary btn-block">
                                        Create Article
                                        <i class="fa fa-pen fa-sm ml-3"></i>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="content">
                    @foreach ($contents as $v)
                        <a href="{{ route('detail', $v->id) }}" class="col-md-6 mb-5 searchable">
                            <div class="card round">
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
                            <a href="{{ route('detail', $v->id) }}" class="col-md-12 mb-5  ">
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
        $(document).ready(function() {
            $(".search").on("keyup change", function() {
                var value = $(this).val().toLowerCase();
                $("#content .searchable").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('.btn-categories').click(function(e) {
                e.preventDefault();
                var val = $(this).data("val");
                $('#c-search').val(val).trigger('change');
            });
        });
    </script>
@endsection
