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
        $search = $request->input('search');
        $categoryId = $request->input('category');
    
        $products = Product::with('category')
            ->when($search, function($query) use ($search) {
                return $query->where('intitule', 'like', '%' . $search . '%');
            })
            ->when($categoryId, function($query) use ($categoryId) {
                return $query->where('cat_id', $categoryId);
            })
            ->paginate(5);  // Make sure you use paginate() and not get()
    
        $categories = Category::all();
    
        return view('products.index', compact('products', 'search', 'categories'));
    }
    
    

    

    // Affiche le formulaire de création de produit
    public function create()
    {
        $categories = Category::all();  // Récupère toutes les catégories
        return view('products.create', compact('categories'));
    }

    // Traite la soumission du formulaire pour ajouter un produit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'intitule' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id', // Ensure the category ID exists
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional photo
        ]);

        $product = new Product();
        $product->intitule = $request->input('intitule');
        $product->prix = $request->input('prix');
        $product->cat_id = $request->input('cat_id'); // This should properly set the category
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('images', 'public');
            $product->image = $imagePath;
        }
        $product->save();

        return redirect()->route('products.index');
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
