@extends("admin/layouts.master")
@section('title','All '. ucfirst(app('request')->input('filter')) .' | ')
@section('content')
    <section class="content-header">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-3">
                        <h1 class="m-0">News List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-3">
                                <a href="{{ route('news-hi.create',['id' => 0]) }}"
                                   class="float-right btn btn-md btn-success">
                                    <i class="fa fa-plus-circle"></i> Add New News
                                </a>
                            </div>
                            <div class="col-sm-9">
                                <form action="{{route('news-hi.index')}}">
                                    <div class="input-group">
                                        <input type="search" name="search" class="form-control form-control-lg" placeholder="Search News Id / News Title / News Slug" value="{{ app('request')->input('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="float:right">Total results found : {{$news->total()}}</h3>
            </div>
            <div class="card-body p-0">
                @if(count($news)>0)
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 10%">Id</th>
                            <th style="width: 45%">Title</th>
                            <th style="width: 5%">Views</th>
                            <th style="width: 5%">Link</th>
                            <th style="width: 5%" class="text-center">Status</th>
                            <th style="width: 10%" class="text-center">Edit</th>
                            <th style="width: 10%" class="text-center">Delete</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($news as $singleNews)

                            <tr>
                                <td>{{$singleNews->id}}</td>
                                <td><a>{{ $singleNews->title }}</a></td>
                                <td>{{ $singleNews->total_views }}</td>
                                <td>
                                    <div class="round-button">
                                        <div class="round-button-circle">
                                            <a href="/news/hindi/{{str_slug($singleNews->title).'.'.$singleNews->id}}"
                                               target="_blank" class="round-button">Go</a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($singleNews->status==1)
                                        <button type="button" class="btn btn-sm btn-success btn-status" data-id="{{$singleNews->id}}">Active</button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-danger btn-status" data-id="{{$singleNews->id}}">Inactive</button>
                                    @endif
                                </td>
                                <td class="project-actions text-center">
                                    <a class="btn btn-info btn-sm" href="{{ route('news-hi.edit',['id' => $singleNews->id]) }}">
                                        <i class="fas fa-pencil-alt"></i>
                                        Edit
                                    </a>

                                </td>
                                <td class="project-actions text-center">

                                    <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#s{{ $singleNews->id }}deleteuser" >
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </a>
                                </td>
                            </tr>

                            <div id="s{{ $singleNews->id }}deleteuser" class="delete-modal modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <div class="delete-icon"></div>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4 class="modal-heading">Are You Sure ?</h4>
                                            <p>Do you really want to delete Author {{ $singleNews->name }}? This process cannot be undone.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post" action="{{route('article.destroy',$singleNews->id)}}" class="pull-right">
                                                {{csrf_field()}}
                                                {{method_field("DELETE")}}
                                                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                                                <button type="submit" class="btn btn-danger">Yes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center col-md-12">
                        <h2 class="text-primary">
                            No News found {{ app('request')->input('q') ? 'with name '.app('request')->input('q') : '' }}
                        </h2>
                    </div>
                @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="dataTables_paginate paging_simple_numbers">
                                {!! $news->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!}
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
@section('page-js-script')
    <script>
        $(document).ready(function () {
            $(".btn-status").click(function () {
                var id = $(this).attr("data-id");
                var status;
                if ($(this).hasClass("btn-success")) {
                    $(this).addClass("btn-danger").removeClass("btn-success").text("Inactive");
                    status = 0
                } else {
                    $(this).addClass("btn-success").removeClass("btn-danger").text("Inactive");
                    $(this).text("Active");
                    status = 1
                }
                $.post(baseUrl + "/admin/news/hindi/status", {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                }, function () {

                });
            });
        });
    </script>
@endsection
