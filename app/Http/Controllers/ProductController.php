<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Affiche la liste des produits
    public function index(Request $request)
    {
        // Retrieve the 'search' query parameter from the request
        $search = $request->input('search');

        // If there is a search query, filter products by 'intitule'
        if ($search) {
            $products = Product::with('category')
                ->where('intitule', 'like', '%' . $search . '%') // Filter products by name (intitule)
                ->paginate(6);
        } else {
            // If no search query, display all products
            $products = Product::with('category')->paginate(6);
        }

        return view('products.index', compact('products', 'search'));
    }

    // Affiche le formulaire de création de produit
    public function create()
    {
        $categories = Category::all();  // Récupère toutes les catégories
        return view('products.create', compact('categories'));
    }

    // Traite la soumission du formulaire pour ajouter un produit
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        
        if ($request->hasFile('photo')) {
            // Store image in 'storage/app/public/images' directory
            $imagePath = $request->file('photo')->store('images', 'public');
            $validated['image'] = $imagePath;
        }
        
        Product::create($validated);  // Create the product in the database
        
        return redirect()->route('products.index')->with('success', 'Produit ajouté avec succès!');
    }

    // Affiche le formulaire d'édition pour un produit spécifique
    public function edit($id)
    {
        $product = Product::findOrFail($id);  // Trouve le produit par son ID
        $categories = Category::all(); // Récupère toutes les catégories

        return view('products.edit', compact('product', 'categories'));  // Passe le produit et les catégories à la vue
    }

    // Met à jour un produit
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);  // Trouve le produit par son ID

        // Validation et traitement de l'image et des autres champs
        $validated = $request->validated();

        // Vérifier si une nouvelle image a été téléchargée
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Stocker la nouvelle image
            $imagePath = $request->file('photo')->store('images', 'public');
            $validated['image'] = $imagePath;
        }

        // Met à jour les informations du produit
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès!');
    }

    // Supprime un produit
    public function destroy($id)
    {
        $product = Product::findOrFail($id);  // Trouve le produit par son ID

        // Supprimer l'image associée du stockage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Supprimer le produit de la base de données
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès!');
    }
}
