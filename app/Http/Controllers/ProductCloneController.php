<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product_Management;
use App\Models\User;
use App\Models\ProductClone;
use Illuminate\Support\Facades\Auth;

class ProductCloneController extends Controller
{

    private function generateUniqueProductId($product_id, $user_id)
    {
        $unique_id = 'P_' . uniqid() . '_' . $product_id . '_' . $user_id;
        return $unique_id;
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = auth()->id();
        $clone = ProductClone::where('user_id', $user_id)->get();
        return view('cart', compact('clone'));
    }

    public function clone(Request $request)
    {
        $product_id = $request->input('product_id');
        $product = Product_Management::find($product_id);
        $user_id = auth()->user()->user_id;
        
        $clone = ProductClone::where('product_id', $product_id)
                             ->where('user_id', $user_id)
                             ->first();
    
        if ($clone) {
            $clone->product_stock += 1;
            $clone->save();
        } else {
            $clone = new ProductClone();
            $clone->fill($product->attributesToArray());
            $clone->product_stock = 1;
            $clone->user_id = $user_id;
            $clone->product_unique_id = $this->generateUniqueProductId($product_id, $user_id); 
            $clone->save();
        }
    
        $product->product_stock -= 1;
        $product->save();
    
        return redirect()->back()->with('success', 'Product cloned successfully!');
    }
    public function showdata()
    {
        $user_id = auth()->id();
        $clone = ProductClone::where('user_id', $user_id)
                             ->where(function($query) use ($user_id) {
                                 $query->whereRaw("SUBSTRING_INDEX(product_unique_id, '_', -1) = {$user_id}")
                                       ->orWhereNull('product_unique_id');
                             })
                             ->get();
    
        return view('cart', compact('clone'));
    }

    
 public function deletion($id){
        $clone = ProductClone::find($id);
        if ($clone) {
            $product = Product_Management::find($clone->product_id);
            if ($product) {
                $product->product_stock += $clone->product_stock;
                $product->save();
            }
            $clone->delete();
            return redirect()->route('product_menu')->with('success', 'Data Successfully Deleted');
        } else {
            return redirect()->route('product_menu')->with('error', 'Data Not Found');
        }
    }

public function Payment(Request $request)
{
    if ($request->isMethod('POST')) {
        $user_id = auth()->user()->user_id;
        $clones = ProductClone::where('user_id', $user_id)->get();

        foreach ($clones as $clone) {
            $product = Product_Management::find($clone->product_id);
            if ($product) {
                $product->product_stock += $clone->product_stock;
                $product->save();
            }
            $clone->delete();
        }

        $total = 0;
        $tax = 0;

        return view('cart', compact('total', 'tax'));
    } else {
        abort(405);
    }
}

 
public function increment($id){
    $clone = ProductClone::find($id);
    $product = Product_Management::find($clone->product_id);
    
    if ($product->product_stock <= 0) {
        return redirect()->back()->with('error', 'Cannot increment, product stock in management is 0!');
    }
    
    $clone->product_stock += 1;
    $clone->save();
    $product->product_stock -= 1;
    $product->save();
    
    return redirect()->back()->with('success', 'Product quantity updated successfully!');
}

public function decrement($id){
    $clone = ProductClone::find($id);
    $product = Product_Management::find($clone->product_id);
    
    if ($clone->product_stock <= 1) {
        return redirect()->back()->with('error', 'Cannot decrement, product quantity in cart is 1!');
    }
    
    $clone->product_stock -= 1;
    $clone->save();
    $product->product_stock += 1;
    $product->save();
    
    return redirect()->back()->with('success', 'Product quantity updated successfully!');
}


}