<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Product;

class ProductController extends Controller
{
    private $branchOptions = ['Sucursal A', 'Sucursal B', 'Sucursal C'];
    const VALIDATION_RULE_REQUIRED_FILLED = 'required|filled';
    const VALIDATION_RULE_NULLABLE_STRING = 'nullable|string';

    public function index()
    {
        $products = Product::where('is_active', true)->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create', ['branchOptions' => $this->branchOptions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => [
                'required',
                'regex:/\S+/',
                'unique:products,code',
            ],
            'name' => self::VALIDATION_RULE_REQUIRED_FILLED,
            'category' => self::VALIDATION_RULE_REQUIRED_FILLED,
            'branch' => self::VALIDATION_RULE_REQUIRED_FILLED,
            'quantity' => 'required|numeric|min:1',
            'sale_price' => 'required|numeric|min:1',
            'description' => self::VALIDATION_RULE_REQUIRED_FILLED,
        ], [
            'code.unique' => 'El código ingresado ya está en uso. Por favor, utiliza un código diferente.',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Producto ingresado correctamente.');
    }

    public function searchForm()
    {
        return view('products.search', ['branchOptions' => $this->branchOptions]);
    }


    public function searchResults(Request $request)
    {
        $request->validate([
            'code' => self::VALIDATION_RULE_NULLABLE_STRING,
            'name' => self::VALIDATION_RULE_NULLABLE_STRING,
            'branch' => 'nullable|string',
        ]);

        $code = $request->input('code');
        $name = $request->input('name');
        $branch = $request->input('branch');


        $searchTerm = $code ?: $name ?: '';

        if (empty($code) && empty($name)) {
            return view('products.search-results', [
                'products' => [],
                'searchParams' => $request->all(),
                'message' => 'Por favor, ingrese al menos un código o un nombre para buscar.',
                'searchTerm' => $searchTerm,
            ]);
        }

        $query = Product::where('is_active', true);

        if ($code) {
            $query->where('code', 'like', "%{$code}%");
        }

        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($branch) {
            $query->where('branch', $branch);
        }

        $products = $query->get();

        if ($products->isEmpty()) {
            return view('products.search-results', [
                'products' => [],
                'searchParams' => $request->all(),
                'message' => 'No se encontraron productos',
                'searchTerm' => $searchTerm,
            ]);
        }

        return view('products.search-results', [
            'products' => $products,
            'searchParams' => $request->all(),
            'message' => null,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'sale_price' => 'required|numeric|min:0',
                'description' => 'required|string',
            ]);

            $product->update($validatedData);

            return redirect()->route('products.index')
                ->with('success', 'Producto actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('products.edit', $id)
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'Ocurrió un error al actualizar el producto.')
                ->withInput();
        }
    }

    public function confirmDelete($id)
    {
        $product = Product::findOrFail($id);
        return view('products.confirm-delete', compact('product'));
    }

    public function deactivate(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->is_active = false;
            $product->save();

            return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Ocurrió un error al borrar el producto.');
        }
    }
}
