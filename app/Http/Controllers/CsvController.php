<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Imports\ProductImport;
use Illuminate\Http\Request;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;

class CsvController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'document_csv' => 'required|mimetypes:text/plain,text/csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:2048'
            ]);
            $file = $request->file('document_csv');
            Excel::import(new ProductImport, $file);

            return redirect()->route('index')->with('success', 'CSV imported successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing ñ: ' . $e->getMessage());
        }
    }

    public function export()
    {
        // Implement export logic here
        return Excel::download(new ProductsExport, 'products.csv');
    }
}
