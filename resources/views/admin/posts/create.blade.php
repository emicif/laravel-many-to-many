@extends('partials/dashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Creazione nuovo post</h1>

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
                <form autocomplete="off" action="{{ route('admin.posts.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Titolo</label>
                        <input type="text" name="title" class="form-control" placeholder="Inserisci titolo"
                            value="{{ old('title') }}" required>

                    </div>
                    <div class="form-group">
                        <label>Contenuto</label>
                        <textarea name="content" class="form-control" placeholder="Inserisci contenuto" required>{{ old('content') }}</textarea>
                    </div>

                    {{-- category --}}
                    <div class="form-group">
                        <label>Categoria</label>
                        <select name="category_id">
                            <option value="">--Scegli la categoria--</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == old('category_id') ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- img --}}
                    <div class="form-group">
                        <label for="image">Immagine Cover</label>
                        <input type="file" name="image" />
                    </div>


                    {{-- tags --}}
                    <div class="form-group">
                        <div>Tags</div>
                        @foreach ($tags as $tag)
                            <input class="form-check-input" type="checkbox" value="{{ $tag->id }}" name="tags[]" />
                            {{-- {{ $post->tags->contains($tag) ? 'checked' : '' }} /> --}}
                            {{-- {{ in_array($tag->id, old('tags', $post->tags)) ? 'checked' : '' }} /> --}}
                            <div class="form-check-label">{{ $tag->name }}</div>
                        @endforeach

                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- submit --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Crea post</button>
                    </div>

                </form>
            </div>

        </div>

    </div>
@endsection
