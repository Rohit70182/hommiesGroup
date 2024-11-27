<?php

namespace Modules\Smtp\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Smtp\Entities\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SmtpAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
     public function accounts()
    {
        $accounts = Account::paginate(20);
        return view('smtp::accounts.accounts',compact('accounts'));
    }
    public function add()
    {
        
        return view('smtp::accounts.add');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('smtp::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        
            $request->validate(
            ['title'=>'required',
             'email'=>'required|email',
             'password'=>' required|min:8',  
              'server'=>' required',
              'port'=>'required',
            
            ]);
            $account=new Account();
            $account->title=$request->input('title');
            $account->email=$request->input('email');
            $account->password=Hash::make($request->password);
            $account->server=$request->input('server');
            $account->created_by_id=Auth::id();
            if($account->save()){
                return redirect('/smtp/account')->with('success',"Details have been saved");
            }
            else{
                return redirect('/smtp/account')->with('error',"Details couldn't be saved");
            }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $account=Account::where('id',$id)->first();
        return view('smtp::accounts/edit',compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('smtp::show');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
          try
            {
                    $request->validate(
                    ['title'=>'required',
                     'email'=>'required|email',
                      'server'=>' required',
                      'port'=>'required',
                    ]);
                $account = Account::find($id);
                $account->title=$request->input('title');
                $account->email=$request->input('email');
                $account->port=$request->input('port');
                $account->server=$request->input('server');
                $account->created_by_id=Auth::id();
                $account->update();
                if($account){
                return redirect('/smtp/account/')->with('status', "details have been Updated Successfully");
            }
        else
        { 
            return redirect('/smtp/account/')->with('status',"couldn't be updated");
        }
        }
        catch(Exception $e)
        {     
                return redirect()->back()->with($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $account=Account::where('id',$id);
        if($account->delete())
        {
            return redirect('/smtp/account')->with('success', 'Smtp record deleted successfully');
        }
        else
        {
                return redirect('/smtp/account')->with('error',"Record could not be deleted");
        }
    }
}
