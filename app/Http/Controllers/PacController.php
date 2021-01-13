<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Wallets;
use App\Packeg;
use Session;
use Auth;

class PacController extends Controller
{
	use Wallets;

	public function __construct()
    {   
        set_time_limit(8000000);
    }

    public function index()
    {
        $packegs = Packeg::orderBy('id')->get();
        return view('admin.pack.index')->withProducts($packegs);
    }

    public function edit($id)
    {
        $packeg = Packeg::find($id);
        return view('admin.pack.edit',compact('packeg'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'title'=>'required|max:255',
            'amount'=>'required',
            'payment'=>'required',
            'exp'=>'required',
            'minWithdraw'=>'required',
            'waiting_day'=>'required',
            ));

        $data = Packeg::find($id);
        $data->title = $request->title;
        $data->amount = $request->amount;
        $data->payment = $request->payment;
        $data->exp = $request->exp;
        $data->minWithdraw = $request->minWithdraw;
        $data->waiting_day = $request->waiting_day;
        $data->save();
        Session::flash('success','Saved');
        return redirect()->back();
    }

    public function bonusDist()
    {
    	$this->dailyBonusDist();
        Session::flash('success','Distribution Complite');
        return redirect()->back();
    }
}
