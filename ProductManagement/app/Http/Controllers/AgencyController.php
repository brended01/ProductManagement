<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\PriceList;
use App\Models\ProductsPriceList;
use App\Models\Work;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agencies');
    }

    public function get()
    {
        $agenies = Agency::withSum('works', 'qty')->get();
        return $agenies;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $dataValidated = $request->validate([
            'name' => 'required'
        ]);

        try {
            $result = Agency::create($dataValidated);

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
            $price_lists = PriceList::where('agency_id', '=', $id)->get();
            foreach ($price_lists as $price_list) {
                ProductsPriceList::where('price_lists_id', '=', $price_list->id)->delete();
            }
            Work::where('agency_id', '=', $id)->delete();

            PriceList::where('agency_id', '=', $id)->delete();

            $result = Agency::destroy($id);
            return response()->json(['success' => true, 'data' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
