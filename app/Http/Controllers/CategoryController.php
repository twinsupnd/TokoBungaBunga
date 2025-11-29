<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Map of flower types to their names
     */
    private $flowerTypes = [
        'mawar' => 'Mawar',
        'lily' => 'Lily',
        'tulip' => 'Tulip',
        'matahari' => 'Matahari',
        'baby-breath' => 'Baby Breath',
    ];

    /**
     * Show flower type category page
     */
    public function showFlowerType($type)
    {
        if (!isset($this->flowerTypes[$type])) {
            abort(404, 'Jenis bunga tidak ditemukan');
        }

        $flowerName = $this->flowerTypes[$type];
        
        // Get products by flower type (search by name)
        $products = Jenis::where('name', 'like', '%' . $flowerName . '%')
            ->orderBy('id')
            ->get();

        return view('categories.flower-type', compact('type', 'flowerName', 'products'));
    }

    /**
     * Show flower model category page
     */
    public function showModel($model)
    {
        $models = ['asli' => 'Bunga Asli', 'tiruan' => 'Bunga Tiruan'];
        
        if (!isset($models[$model])) {
            abort(404, 'Model bunga tidak ditemukan');
        }

        $modelName = $models[$model];
        
        // For now, get all products (you can add a model field to Jenis table later)
        $products = Jenis::orderBy('id')->get();

        return view('categories.flower-model', compact('model', 'modelName', 'products'));
    }
}
