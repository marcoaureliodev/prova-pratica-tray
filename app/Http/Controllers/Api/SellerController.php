<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSellerRequest;
use App\Http\Resources\SellerResource;
use App\Models\Seller;

class SellerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
     public function index()
     {
        return SellerResource::collection(Seller::all());
        //Ação 4: Commit do Progresso
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSellerRequest $request)
    {
        $seller = Seller::create($request->validated());
        return new SellerResource($seller);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
