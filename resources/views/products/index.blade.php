@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Produits</h1>

        <!-- Display success message if it exists -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Create Button -->
        <div class="mb-4">
            <a href="{{ route('products.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Créer un Produit
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('products.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Rechercher par intitulé" value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Rechercher</button>
            </div>
        </form>

        <!-- Refresh Button (with icon) -->
        <form action="{{ route('products.index') }}" method="GET" class="mb-4">
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-sync-alt"></i> Réinitialiser la recherche
            </button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom du Produit</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->intitule }}</td>
                        <td>{{ $product->prix }}</td>
                        <td>{{ $product->category ? $product->category->intitule : 'Non défini' }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Modifier</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="d-flex justify-content-center">
            {{ $products->links() }}  <!-- Display pagination links -->
        </div>
    </div>
@endsection
