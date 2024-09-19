<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::select('codigo as Código', 'nombre as Nombre', 'descripcion as Descripción',
        'categoria as Categoría', 'precio as Precio', 'stock as Inventario')->orderBy('codigo')->get();
        return response()->json(['status' => 'success', 'data' => $products]);
    }

    public function store(Request $request)
    {
        try {
            $product = Product::create($request->all());
            return response()->json(['status' => 'success',
            'message' => 'Registro creado exitosamente.', 'data' => $product]);
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'No se pudo crear el registro.']);
        }
    }

    public function show(string $value)
    {
        try {
            $product = Product::where('id', $value)->orWhere('codigo', $value)->orWhere('nombre', $value)->firstOrFail();
            return response()->json(['status' => 'success',
            'message' => 'Se está mostrando el registro.', 'data' => $product]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($request->all());
            return response()->json(['status' => 'success', 'message' => 'Producto actualizado exitosamente.',
            'data' => $product]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json(['status' => 'success', 'message' => 'Producto eliminado exitosamente.',
            'data' => $product]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
