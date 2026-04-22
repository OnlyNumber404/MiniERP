<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function Category(){
        // $category = [
        //     ['name' => 'Makanan', 'tipe' => 'expense'],
        //     ['name' => 'Transportasi', 'tipe' => 'expense'],
        //     ['name' => 'Gaji', 'tipe' => 'income'],
        //     ['name' => 'Sewa Rumah', 'tipe' => 'expense'],
        //     ['name' => 'Donasi', 'tipe' => 'expense'],
        // ];

        $category = Category::all();

        return view('categories', compact('category'));
    }
}