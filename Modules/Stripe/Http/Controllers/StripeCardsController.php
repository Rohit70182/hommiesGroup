<?php

namespace Modules\Stripe\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use Modules\Stripe\Entities\StripeCard;
use Modules\Stripe\Entities\StripeSetting;

class StripeCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('stripe::cards.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('stripe::cards.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        try {   

            $stripe_setting = StripeSetting::select('*')->first();
            if(!$stripe_setting){
                return 'Data not found';   
            }

            $stripe = new \Stripe\StripeClient(
                $stripe_setting->secret_key
            );
            $responce = $stripe->tokens->create([
                'card' => [
                'number' => $request->card_number,
                'exp_month' => $request->card_month,
                'exp_year' => $request->card_year,
                'cvc' => $request->card_cvc,
                ],
            ]);

            $stripe_card = new StripeCard();
            $stripe_card->card_id = $responce['card']['id'];
            $stripe_card->customer_id = 1;
            $stripe_card->response = $responce;
            $stripe_card->created_by_id = Auth::user()->id;
            if($stripe_card->save()){
                $data = [
                    'code' => 200,
                    'url' => '/stripe/cards',
                    'message' => 'Data saved successfully',
                ];
                return $data;
            }
            

        } catch (Exception $e) {	
            $data = [
                'code' => 500,
                'url' => '',
                'message' => $e->getMessage(),
            ];
            return $data;
        }
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('stripe::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('stripe::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
