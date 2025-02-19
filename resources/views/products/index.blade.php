@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="header text-center mb-4">Gestion des Produits</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

       <!-- Add Product Button and Search Form -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Add Product Button -->
            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm p-2">
                <i class="fas fa-plus"></i> Créer un Produit
            </a>

            <!-- Search Form -->
            <form action="{{ route('products.index') }}" method="GET" class="form-inline ml-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Rechercher par intitulé" value="{{ request('search') }}">
                    <select name="category" class="form-control ml-2">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->intitule }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary ml-2">
                        <i class="fas fa-search"></i> Chercher
                    </button>
                </div>
            </form>
        </div>


        <!-- Product Table -->
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
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
                        <td>{{ $product->prix }} €</td>
                        <td>{{ $product->category ? $product->category->intitule : 'Non défini' }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->intitule }}" class="img-thumbnail" width="100">
                            @else
                                <p>No image</p>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> 
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-around">
            {{ $products->links() }}
        </div>
    </div>
@endsection
