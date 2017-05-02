<?php

namespace Eanstore\Http\Controllers;

use Eanstore\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return view('products.list')->with('products', $products);
    }

    public function search(Request $request)
    {
        $barcode = $request->input('barcode', '');

        $products = Product::where('ean', '=', $barcode);

        if($products->count() == 1) {
            return redirect()->action('ProductController@show', ['id' => $products->first()]);
        } else {
            return view('products.list')->with('products', $products->get());
        }   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.register');
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
            'name' => 'required|max:255',
            'description' => 'required',
            'barcode' => 'required|unique:products,ean',
        ]);

        $name = $request->input('name', '');
        $description = $request->input('description', '');
        $barcode = $request->input('barcode', '');

        $product = new Product();
        $product->name = $name;
        $product->description = $description;
        $product->ean = $barcode;
        $product->save();

        return redirect()->action('ProductController@create')
            ->with('message', 'Your product has been registered.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if($product === null) {
            return redirect()->action('ProductController@index');
        }

        return view('products.single')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
