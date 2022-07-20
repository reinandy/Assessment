@extends('layout.default')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif
    <div class="card">
        <div class="card-header py-5">
            <div class="d-flex justify-content-between align-items-center">
                <span id="card_title">
                    <h4 class="m-0">{{ __('List '.$pageTitle) }}</h4>
                </span>
                <div class="float-right">
                    @can($permissionName.'-create')
                        <a href="{{ route($routePath.'.create') }}" class="btn btn-primary btn-sm float-right font-weight-bolder btn-add">
                            <i class="fa fa-plus-circle"></i>New Record
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="DataTable" class="table table-striped table-bordered table-hover w-100">
                </table>
            </div>
        </div>
    </div>

    <!-- Modal-->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title"><span id="mtitle"></span> {{ $pageTitle }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    @include('permission.form')
                </div>
        
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModalShow">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Detail {{ $pageTitle }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body" id="show-body">
                </div>
        
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            var action = "{{ route($routePath.'.store') }}";
            var table = $('#DataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route($routePath.'.index') }}",
                columns: [
                    {
                        title: 'Action',
                        class: 'text-center',
                        width: '1%',
                        data: 'id',
                        orderable: false,
                        render: function(id, x, r) {
                            return `
                                <form action="{{ route($routePath.'.index') }}/${id}" method="POST" class="d-flex">
                                    @can($permissionName.'-show')
                                        <a class="btn btn-primary btn-xs d-flex justify-content-center align-items-center btn-show" href="{{ route($routePath.'.index') }}/${id}"><i class="fa fa-fw fa-eye p-0"></i></a>
                                    @endcan
                                    @can($permissionName.'-edit')
                                        <a class="btn btn-success btn-xs d-flex justify-content-center align-items-center btn-edit" href="{{ route($routePath.'.index') }}/${id}/edit" data-json='${JSON.stringify(r)}''><i class="fa fa-pencil-alt p-0"></i></a>
                                    @endcan
                                    @can($permissionName.'-delete')
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs d-flex justify-content-center align-items-center btn-delete"><i class="fa fa-trash-alt p-0"></i></button>
                                    @endcan
                                </form>
                            `;
                        }
                    },
                    {
                        title: 'No',
                        class: 'text-center',
                        width: '1%',
                        data: 'id',
                        render: function (id, x, t) {
                            return t.idx;
                        }
                    },
                    {
                        title: 'name',
                        data: 'name'
                    },
                ],
                order: [[ 1, "DESC" ]]
            });
            table.column(1).visible(false)

            // table.on( 'draw.dt', function () {
            //     var info = table.page.info();
            //     var i = 0;
            //     for (let x = (info.start + 1); x <= info.end; x++) {
            //         table.column(0).nodes()[i].innerHTML = x;
            //         i++;
            //     }
            // } ).draw();

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
                            success: function (r) {
                                Swal.fire({
                                    icon: 'success',
                                    title: r.message
                                });
                                
                                table.ajax.reload();
                            },
                            error: function (e) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'An error occurred.'
                                });
                            },
                        });
                    }
                })
            });

            $('.btn-add').click(function (e) { 
                e.preventDefault();

                $('.form-group input, select').val('');
                $('#mtitle').text('Create');
                $('form').attr('action', action);
                $('form').find('input[name="_method"]').val('POST');
                $('#myModal').modal('show');
            });

            $('form').submit(function (e) { 
                event.preventDefault();

                var form = $(this);
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function (r) {
                        Swal.fire({
                            icon: 'success',
                            title: r.message
                        });
                        
                        table.ajax.reload();
                        $('#myModal').modal('hide');
                    },
                    error: function (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred.'
                        });
                    },
                });
            });

            $('body').on('click', '.btn-edit', function(event) {
                event.preventDefault();

                var data = JSON.parse($(this).attr('data-json'));
                $.each(data, function (i, v) { 
                    $(`.form-group input[name="${i}"]`).val(v);
                });

                $('#mtitle').text('Update');
                $('form').attr('action', action + '/' + data.id);
                $('form').find('input[name="_method"]').val('PATCH');
                $('#myModal').modal('show');
            });

            $('body').on('click', '.btn-show', function(event) {
                event.preventDefault();
                var link = $(this).attr('href');
                $.ajax({
                    type: "get",
                    url: link,
                    dataType: "html",
                    success: function (r) {
                        $('#show-body').html(r);
                        $('#myModalShow').modal('show');
                    },
                    error: function (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred.'
                        });
                    },
                });
            });
        });
    </script>
@endsection
