@extends('layouts.app')

@section('content')
    <h1>Ajouter un produit</h1>
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom du produit</label>
            <input type="text" class="form-control" id="name" name="intitule" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Prix</label>
            <input type="number" class="form-control" id="price" name="prix" required>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Catégorie</label>
            <select class="form-control" name="cat_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->intitule }}</option>
                @endforeach
            </select>
            
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
@endsection
