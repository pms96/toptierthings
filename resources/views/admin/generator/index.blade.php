@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Url List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('website') }}">Home</a></li>
                    <li class="breadcrumb-item active">Url list</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Url List</h3>
                            <a href="{{ route('urlgenerator.create') }}" class="btn btn-primary">Create Url</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 30px">#</th>
                                    <th>url</th>
                                    <th>posted</th>
                                    <th>post_id</th>
                                    <th style="width: 130px">Created Date</th>
                                    <th style="width: 40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($urls->count())
                                @foreach ($urls as $url)
                                    <tr>
                                        <td>{{ $url->product_code }}</td>
                                        <td>{{ Str::of($url->url)->limit(70) }}</td>
                                        <td>{{ $url->post }}</td>
                                        <td>{{ $url->post_id }}</td>
                                        <td style="width: 130px">{{ $url->created_at->format('d M, Y') }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('urlgenerator.show', [$url->product_code]) }}" class="btn btn-sm btn-success mr-1"> <i class="fas fa-eye"></i> </a>
                                            <a href="{{ route('urlgenerator.edit', [$url->product_code]) }}" class="btn btn-sm btn-primary mr-1"> <i class="fas fa-edit"></i> </a>
                                            @if($url->post_id)
                                            <a href="{{ route('post.show', [$url->post_id]) }}" target="_blank" class="btn btn-sm btn-dark mr-1"> <i class="fas fa-link"></i> </a>
                                            @endif
                                            <form action="{{ route('urlgenerator.destroy', [$url->product_code]) }}" class="mr-1" method="POST">
                                                @method('DELETE')
                                                @csrf 
                                                <button type="submit" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i> </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @else   
                                    <tr>
                                        <td colspan="6">
                                            <h5 class="text-center">No urls found.</h5>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer d-flex justify-content-center">
                        {{ $urls->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection