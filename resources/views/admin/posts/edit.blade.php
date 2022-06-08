@extends('partials/dashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Modifica post {{ $post->id }}</h1>

                </div>
                <div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
                </div>
                <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- aggiunto metodo --}}
                    @method('PUT')
                    <div class="form-group">
                        <label>Titolo</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}"
                            required>

                    </div>

                    {{-- image --}}
                    <div class="form-group">
                        @if ($post->cover)
                            <div>
                                <img src="{{ asset('storage/' . $post->cover) }}" alt="">
                            </div>
                        @endif
                        <label for="image">Immagine cover </label>
                        <input type="file" name="image" />
                    </div>


                    <div class="form-group">
                        <label>Contenuto</label>
                        <textarea name="content" class="form-control" required>{{ old('content', $post->content) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Categoria</label>
                        <select name="category_id">
                            <option value="">--Scegli la categoria--</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == old('category_id', $post->category_id) ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- tags --}}
                    <div class="form-group">
                        <div>Tags</div>
                        @foreach ($tags as $tag)
                            @if ($errors->any())
                                <input class="form-check-input" type="checkbox" value="{{ $tag->id }}" name="tags[]"
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} />
                            @else
                                <input class="form-check-input" type="checkbox" value="{{ $tag->id }}" name="tags[]"
                                    {{ $post->tags->contains($tag) ? 'checked' : '' }} />
                            @endif
                            <div class="form-check-label">{{ $tag->name }}</div>
                        @endforeach

                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Aggiorna post</button>
                    </div>

                </form>
            </div>

        </div>

    </div>
@endsection
