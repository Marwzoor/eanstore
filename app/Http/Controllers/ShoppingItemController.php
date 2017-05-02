<?php

namespace Eanstore\Http\Controllers;

use Eanstore\Product;
use Eanstore\ShoppingItem;

use Eanstore\Jobs\SyncShoppingItemsToWunderlist;

use Illuminate\Http\Request;

class ShoppingItemController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shoppingItems = ShoppingItem::all();

        return view('shopping-items.list')->with('shoppingItems', $shoppingItems);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shopping-items.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'barcode' => 'required|exists:products,ean',
        ]);

        $barcode = $request->input('barcode', '');

        $product = Product::where('ean', '=', $barcode)->first();

        $shoppingItem = ShoppingItem::where('product_id', '=', $product->id)->first();

        if($shoppingItem === null) {
        	$shoppingItem = new ShoppingItem();
        	$shoppingItem->quantity = 1;
        	$shoppingItem->product_id = $product->id;
        } else {
        	$shoppingItem->quantity += 1;
        }

        $shoppingItem->save();

        dispatch(new SyncShoppingItemsToWunderlist);

        return redirect()->action('ShoppingItemController@create')
        	->with('message', sprintf('"%s" added to shopping list.', $product->name));
    }
}
