@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier le Produit</h1>

        <!-- Display success message if it exists -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Edit Form -->
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="intitule" class="form-label">Nom du Produit</label>
                <input type="text" class="form-control @error('intitule') is-invalid @enderror" id="intitule" name="intitule" value="{{ old('intitule', $product->intitule) }}" required>
                @error('intitule')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="number" step="0.01" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', $product->prix) }}" required>
                @error('prix')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cat_id" class="form-label">Catégorie</label>
                <select class="form-select @error('cat_id') is-invalid @enderror" id="cat_id" name="cat_id" required>
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->cat_id == $category->id ? 'selected' : '' }}>
                            {{ $category->intitule }}
                        </option>
                    @endforeach
                </select>
                @error('cat_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Image</label>
                <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                @error('photo')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Existing image preview -->
            @if($product->photo)
                <div class="mb-3">
                    <label class="form-label">Image actuelle</label><br>
                    <img src="{{ asset('storage/' . $product->photo) }}" alt="Image du produit" class="img-thumbnail" width="150">
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Retour</a>
        </form>
    </div>
@endsection
