<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SellingPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::query();
        if(request()->keywords != null)
        {
            $products =  $products->search(request()->keywords);
        }
        $products = $products->paginate(6);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:products,name',
            'description' => 'string|nullable',
            'selling_price' => 'numeric|nullable'
        ], [
            'name.required' => 'يرجى إدخال اسم المنتج',
            'name.string' => 'يرجى إدخال اسم المنتج بشكل صحيح',
            'name.unique' => 'هذا المنتج موجود بالفعل يرجى أدخال أسم منتج آخر',
            'description.string' => 'يرجى إدخال وصف المنتج بشكل صحيح',
            'selling_price.numeric' => 'يرجى إدخال سعر بيع المنتج بشكل صحيح'
        ]);
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        SellingPrice::create([
            'product_id' => $product->id,
            'selling_price' => $request->selling_price
        ]);

        return redirect()->route('product.index')->with('success', 'تم إضافة المنتج ' . $product->name . ' بنجاح ');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {

        $startDate = Carbon::now()->subDays(6)->format('Y-m-d');
        $endDate = Carbon::now()->format('Y-m-d');
        $product = Product::where('name', $name)->first();
        $products = $product->bellSales()->whereHas('invoices')->get();
        $amountOfWeek = $product->bellSales()->whereHas('invoices',function  ($q) use ($startDate,$endDate){
            $q->whereBetween(DB::raw('DATE(invoices.created_at)'), [$startDate, $endDate]);
        })->sum('amount');
        $purchasePrice = $product->bellPurchases()->orderBy('created_at', 'desc')->first();
        return view('products.view', compact('product', 'amountOfWeek', 'purchasePrice','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required|string|unique:products,name,$product->id",
            'selling_price' => 'numeric|nullable',
            'description' => 'string|nullable',
        ], [
            'name.required' => 'يرجى إدخال اسم المنتج',
            'name.string' => 'يرجى إدخال اسم المنتج بشكل صحيح',
            'selling_price.string' => 'يرجى إدخال سعر المنتج بشكل صحيح',
            'name.unique' => 'هذا المنتج موجود بالفعل يرجى أدخال أسم منتج آخر',
            'description.string' => 'يرجى إدخال وصف المنتج بشكل صحيح',
        ]);
        if ($validator->fails()) {
            $validator->errors()->add('product_id', $product->id);
            return redirect()->back()->withErrors($validator);
        }
        $product->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        $product->sellingPrice->selling_price = $request->selling_price;
        $product->sellingPrice->save();
        return redirect()->back()->with('success', 'تم تعديل المنتج ' . $product->name . ' بنجاح ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        if (!$product->bellSales->isEmpty() || !$product->bellPurchases->isEmpty()) {
            return redirect()->back()->with('error', 'لن تتم عملية حذف المنتج لأن به حركات');
        }
        $product->delete();
        return redirect()->back()->with('success', 'تم حذف المنتج ' . $product->name . ' بنجاح ');
    }


}
