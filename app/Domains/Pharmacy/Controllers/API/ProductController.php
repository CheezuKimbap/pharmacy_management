<?php

namespace App\Domains\Pharmacy\Controllers\API;

use App\Domains\Pharmacy\Services\ProductService;
use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Domains\Pharmacy\Mapper\MedicineMapper;
class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
         $products = $this->productService->getAllProducts();

        $medicines = collect($products)->map(function ($product) {
            return MedicineMapper::toArray(MedicineMapper::fromProduct($product));
        });

   
   

        return response()->json($medicines);
    }

    public function show($id)
    {
        $product = $this->productService->findProductById($id);
        if ($product) {
            return response()->json($product);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }

    public function store(Request $request)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'stock' => 'integer|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date',
            'description' => 'nullable|string',
            'how_to_use' => 'nullable|string',
            'side_effects' => 'nullable|string',
        ]);
       
          $product = $this->productService->createProduct($validated);
          
          return response()->json(['message' => 'Product Created'], 200);  
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $product = $this->productService->updateProduct($id, $data);
        if ($product) {
            return response()->json($product);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }

    public function destroy($id)
    {
        if ($this->productService->deleteProduct($id)) {
            return response()->json(['message' => 'Product deleted successfully']);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }
} 