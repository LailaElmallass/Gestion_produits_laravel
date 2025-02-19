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
                <select name="category" class="form-control">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->intitule }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">chercher</button>
            </div>
        </form>
        

       <!-- Refresh Button (with icon) -->
       <form action="{{ route('products.index') }}" method="GET" class="mb-4">
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-sync-alt"></i> 
            </button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom du Produit</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Image</th>
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
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Image de {{ $product->intitule }}" class="img-thumbnail" width="100">
                            @else
                                <p>No image available</p>
                            @endif

                        </td>
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
        <div class="d-flex justify-content-center">
            @if ($products->hasPages())
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                            &laquo;
                        </a>
                    </li>
        
                    {{-- Pagination Elements --}}
                    @foreach ($products->links() as $link)
                        <li class="page-item"><a class="page-link" href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
        
                    {{-- Next Page Link --}}
                    <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                            &raquo;
                        </a>
                    </li>
                </ul>
            @endif
        </div>
        
        
    </div>
@endsection
