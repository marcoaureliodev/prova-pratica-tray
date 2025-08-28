<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use App\Http\Resources\SaleResource;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Mail\SellerDailyReport;
use Illuminate\Support\Facades\Mail;

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

    public function sales(Seller $seller)
    {
        $sales = $seller->sales()->with('seller')->get();
        return SaleResource::collection($sales);
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

    public function resendReport(Seller $seller)
    {
        $yesterday = now()->subDay();

        $sales = $seller->sales()
                        ->whereDate('sale_date', $yesterday)
                        ->get();

        if ($sales->isEmpty()) {
            return response()->json(['message' => 'Nenhuma venda encontrada para este vendedor ontem.'], 404);
        }

        $salesCount = $sales->count();
        $totalValue = $sales->sum('value');
        $totalCommission = $totalValue * 0.085;

        Mail::to($seller)->queue(new SellerDailyReport($salesCount, $totalValue, $totalCommission));

        return response()->json(['message' => 'E-mail de relatório reenviado para a fila com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
