<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    private $branchOptions = ['Sucursal A', 'Sucursal B', 'Sucursal C'];
    const VALIDATION_RULE_REQUIRED_FILLED = 'required|filled';
    const VALIDATION_RULE_NULLABLE_STRING = 'nullable|string';

    public function index()
    {
        $products = Product::all();
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
            'code.unique' => 'El código ingresado ya está en uso. Por favor, utiliza un código diferente.', // Mensaje personalizado
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


        if (empty($code) && empty($name)) {
            return view('products.search-results', [
                'products' => [],
                'searchParams' => $request->all(),
                'message' => 'Falta añadir los campos requeridos: código y nombre.',
            ]);
        }

        $missingFields = [];
        if (empty($code)) {
            $missingFields[] = 'código';
        }
        if (empty($name)) {
            $missingFields[] = 'nombre';
        }

        if (!empty($missingFields)) {
            return view('products.search-results', [
                'products' => [],
                'searchParams' => $request->all(),
                'message' => 'Falta añadir el campo requerido: ' . implode(' y ', $missingFields) . '.',
            ]);
        }

        $query = Product::query();

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
                'message' => 'No se encontraron productos con los criterios de búsqueda especificados.',
            ]);
        }

        return view('products.search-results', [
            'products' => $products,
            'searchParams' => $request->all(),
            'message' => null,
        ]);
    }
}
