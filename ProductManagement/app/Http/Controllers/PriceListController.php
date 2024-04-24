<?php

namespace App\Http\Controllers;

use App\Models\PriceList;
use App\Models\ProductsPriceList;
use App\Models\Work;
use Illuminate\Http\Request;

class PriceListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('price_list');
    }

    public function get(Request $request)
    {

        if ($request->input('agency_id') && $request->input('product_id')) {

            $priceListsIds = ProductsPriceList::where('products_id', $request->input('product_id'))
                ->pluck('price_lists_id');

            if ($priceListsIds) {
                $priceLists = PriceList::where('agency_id', '=', $request->input('agency_id'))
                    ->whereIn('id', $priceListsIds)
                    ->get();
            }
        } else if ($request->input('agency_id')) {
            $priceLists = PriceList::where('agency_id', '=', $request->input('agency_id'))
                ->get();
        } else {
            $priceLists = PriceList::with('agency')->with('productsPriceLists.products')->get();
        }
        return $priceLists;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $dataValidate = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'agency' => 'required',
            'products' => 'required'
        ]);
        $dataFormatted = [
            'name' => $dataValidate['name'],
            'price' => $dataValidate['price'],
            'agency_id' => $dataValidate['agency']['id']
        ];
        try {

            $result = PriceList::create($dataFormatted);

            foreach ($dataValidate['products'] as $product) {

                $dataFormatted = [
                    'products_id' => $product['id'],
                    'price_lists_id' => $result->id
                ];

                ProductsPriceList::create($dataFormatted);
            }

            return response()->json(['success' => true, 'data' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Request $request)
    {
        $id = $request->input('id');

        try {
            Work::where('price_lists_id', '=', $id)->delete();

            ProductsPriceList::where('price_lists_id', '=', $id)->delete();
            $result = PriceList::destroy($id);

            return response()->json(['success' => true, 'data' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
