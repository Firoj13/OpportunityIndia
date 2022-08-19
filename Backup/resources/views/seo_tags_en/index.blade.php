@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Seo Tags English</h2>
            </div>
            <div class="pull-right">
                @can('seo_tag_en-create')
                    <a class="btn btn-success" href="{{ route('seo-tags-en.create') }}"> Create New Seo Tags</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>slug</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($tags as $tag)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $tag->name }}</td>
                <td>{{ $tag->slug }}</td>
                <td>
                    <form action="{{ route('seo-tags-en.destroy',$tag->id) }}" method="POST">
{{--                        <a class="btn btn-info" href="{{ route('seo-tags-en.show',$tag->id) }}">Show</a>--}}
                        @can('seo_tag_en-edit')
                            <a class="btn btn-primary" href="{{ route('seo-tags-en.edit',$tag->id) }}">Edit</a>
                        @endcan


                        @csrf
                        @method('DELETE')
                        @can('seo_tag_en-delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </table>


    {!! $tags->links() !!}


@endsection
