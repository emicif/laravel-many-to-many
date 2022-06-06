@extends('partials/dashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Visualizzazione post {{ $post->id }}</h1>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">Tutti i post</a>
                </div>
                <dl>
                    <dt>Titolo</dt>
                    <dd>{{ $post->title }}</dd>
                    <dt>Slug</dt>
                    <dd>{{ $post->slug }}</dd>
                    <dt>Contenuto</dt>
                    <dd>{{ $post->content }}</dd>
                    <dt>Categoria</dt>
                    <dd>{{ $category->name }}</dd>
                </dl>

                {{-- modifica --}}
                <a class="btn btn-warning" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">EDIT</a>

                {{-- elimina --}}
                <form autocomplete="off" action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        ELIMINA
                    </button>



                </form>
            </div>

        </div>

    </div>
@endsection
