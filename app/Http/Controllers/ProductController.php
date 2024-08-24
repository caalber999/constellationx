<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Muestra una lista de productos
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Muestra el formulario para crear un nuevo producto
    public function create()
    {
        return view('products.create');
    }

    // Almacena un nuevo producto en la base de datos
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|max:2048', // Asegúrate de que la imagen es válida
        ]);

        // Procesar la imagen y guardarla en el sistema de archivos
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = '/storage/' . $imagePath;
        }

        // Crear el producto
        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    // Muestra un producto específico
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Muestra el formulario para editar un producto existente
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Actualiza un producto en la base de datos
    public function update(Request $request, Product $product)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        // Procesar la imagen si es nueva
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = '/storage/' . $imagePath;
        }

        // Actualizar el producto
        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    // Elimina un producto de la base de datos
    public function destroy(Product $product)
    {
        // Eliminar el producto
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
    // Mostrar catálogo de productos
    public function catalog()
    {
        $products = Product::all();
        return view('products.catalog', compact('products'));
    }
}
