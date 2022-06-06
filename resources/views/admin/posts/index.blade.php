@extends('partials/dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Tutti i post</h1>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Crea nuovo post</a>
            </div>


            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titolo</th>
                        <th>Slug</th>
                        <th>Azioni</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->slug }}</td>
                            <td>
                                <a class="btn btn-info"
                                    href="{{ route('admin.posts.show', ['post' => $post->id]) }}">SHOW</a>
                                <a class="btn btn-warning"
                                    href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">EDIT</a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
