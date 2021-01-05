<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Wallets;
use App\Wallet;
use App\AdminWallet;
use App\EarnWallet;
use App\UserPin;
use App\User;
use Session;
use Carbon\Carbon;
use Auth;
use DB;

class HomeController extends Controller
{
    use Wallets;
    private $withdrowAmt = 3;
    private $transferToWW = 0;
    private $mBonus = 10;
    private $dayLimit = 200;
    private $freeLimit = 50;
    private $upgrateAmt = 120;
    private $count = 1;
    private $lCcount = 1;

    public function pending(){
         return view('pages.pending');
    }

    public function index(){
        //$this->matchingBonusDist(); exit;
        $this->rank();
        $this->checkVIP();
        $slotAmt = $this->slot();
        $user_id= Auth::user()->id;
       $wallets=$this->allBalance($user_id);
       $wallets['withdrawTotal'] = ['balance'=>$this->widBalance($user_id),'title'=>'Income wallet','bg'=>'1'];
       //$wallets['sponsorTotal'] = ['balance'=>$this->totalBalance($user_id,'sponsorWallet'),'title'=>'Total Sponsor Income','bg'=>'2'];
       $wallets['dailyWallet'] = ['balance'=>$this->totalBalance($user_id,'dailyWallet'),'title'=>'Total Profit','bg'=>'3'];
       //$wallets['registeredTotal'] = ['balance'=>Auth::user()->sponsorChilds->count(),'title'=>'Total Registered','bg'=>'4'];
       //$wallets['wrTotal'] = ['balance'=>$this->withdrawalRequest($user_id),'title'=>'Withdrawal Request Total','bg'=>'5'];
       //$wallets['wsTotal'] = ['balance'=>$this->withdrawalRequestSuccess($user_id),'title'=>'Withdrawal Success Total','bg'=>'6'];
       //$wallets['frTotal'] = ['balance'=>$this->totalReceive($user_id),'title'=>'Total Fund Receive','bg'=>'1'];
       //$wallets['ftTotal'] = ['balance'=>$this->totalTransfar($user_id),'title'=>'Total Fund Transfer','bg'=>'2'];
       $wallets['lvTotal'] = ['balance'=>$slotAmt['lvTotal'],'title'=>'Volume 1','bg'=>'3'];
       $wallets['rvTotal'] = ['balance'=>$slotAmt['rvTotal'],'title'=>'Volume 2','bg'=>'4'];

       $wallets2 = array();
       $percent=['balance'=>$this->ckDailyIncomePercent(Auth::user()),'title'=>'Profit','bg'=>'5'];
       //$wallets2['rankName'] = ['balance'=>'Rank','title'=>$this->rank[Auth::user()->rank]['title'],'bg'=>'6'];
       //$wallets2['myPackeg'] = ['balance'=>Auth::user()->packeg->title,'title'=>'My Packeg','bg'=>'1'];
       if(Auth::user()->packeg_id == 8){
        //$wallets2['globalStatus'] = ['balance'=>Auth::user()->vip.' Star','title'=>'Global Status','bg'=>'3'];
        }
       //dd($wallets2); exit;
        return view('pages.dashboard',compact('wallets','wallets2','percent'));
    }


    public function checkVIP(){

        if(Auth::user()->packeg_id == 3){
            $members = User::where('packeg_id',3)->where('id','>',Auth::user()->id)->count();
            $userVIP = Auth::user()->vip;
            $userVIP++;
            $vip = $this->vip;
            //dd($cLeft); exit;
            if($members >= $vip[$userVIP]['point']){

                $user = User::find(Auth::user()->id);
                $user->vip = $userVIP;
                $user->save();

                $data2 = new Wallet;
                $data2->user_id = Auth::user()->id;
                $data2->receipt = $vip[$userVIP]['amount'];
                $data2->wType = 'globalIncome';
                $data2->remark = 'VIP Incentive #'.$userVIP;
                $data2->save();
            }
        }
    }

    public function vipMembers(){
        // if(Auth::user()->packeg_id != 3){
        //     return redirect()->route('home');
        // }
        $members = User::where('packeg_id',3)->orderBy('id')->get();//->where('id','>',Auth::user()->id)
        return view('pages.vipMembers',compact('members'));
    }


    public function rankList(){
       $rankInfo = $this->rank;
       array_shift($rankInfo);
       //dd($rankInfo);
        return view('pages.rankList',compact('rankInfo'));
    }

    public function vipList(){
       $rankInfo = $this->vip;
       array_shift($rankInfo);
       //dd($rankInfo);
        return view('pages.vipList',compact('rankInfo'));
    }

    public function matchinList(){
       $rankInfo = $this->slot;
       array_shift($rankInfo);
       //dd($rankInfo);
        return view('pages.matchinList',compact('rankInfo'));
    }

    public function memberList()
    {
        $totalMember = User::myChild(Auth::user()->id);
        $members = User::where('placementId',Auth::user()->id)->get();
        return view('pages.memberList',compact('members','totalMember'));
    }

    public function mySponsor()
    {
        $members = User::where('referralId',Auth::user()->id)->get();
        return view('pages.mySponsor',compact('members'));
    }

    public function memberListId($id)
    {
        $totalMember = User::myChild($id);
        $members = User::where('placementId',$id)->get();
        return view('pages.memberList',compact('members','totalMember'));
    }

    public function myWallet($wallet)
    {
        $transaction = $this->listBalance(Auth::user()->id,$wallet);
        $balance = $this->balance(Auth::user()->id,$wallet);
        $walletInfo = $this->wallets[$wallet];
        return view('pages.wallet',compact('transaction','balance','walletInfo','wallet'));
    }

    public function withdrawals($type,$type2)
    {
        if($type=='AgentWithdrawals'){
            $bankName = [
                'bKash'=>'bKash',
                'Rocket'=>'Rocket',
                'Nagad'=>'Nagad',
                'Bank '=>'Bank',
              ];
          }elseif($type=='OnlineWithdrawals'){
              $bankName = [
                'Perfect money'=>'Perfect money',
                'PayPal'=>'PayPal',
                'btc'=>'btc',
              ];
        }else{
            return redirect()->back();
        }

        if($type2=='withdrawWallet'){
            $wallet = 'withdrawWallet';
        }elseif($type2=='dailyWallet'){
            $wallet = 'dailyWallet';
        }else{
            return redirect()->back();
        }

        
        $title = 'Withdraw Balance';
        return view('wallet.withdrawFrom',compact('title','wallet','bankName'));
    }
    public function withdrawWallet()
    {
        $transaction = $this->listBalance(Auth::user()->id,'withdrawWallet');
        $balance = $this->widBalance(Auth::user()->id);
        $wallet = 'withdrawWallet';
        $walletName = 'Withdraw Repoer';
        return view('wallet.withdrawWallet',compact('transaction','balance','walletName','wallet'));
    }

    public function rank(){
        $userRank = Auth::user()->rank;

        if($userRank == 0){
            $cLeft=User::myChildAmount(Auth::user()->id,1);
            $cRight=User::myChildAmount(Auth::user()->id,2);           
        }else{
            $cLeft=User::myChildByPack(Auth::user()->id,1,$userRank);
            $cRight=User::myChildByPack(Auth::user()->id,2,$userRank); 
        }
        
        if($cLeft<=$cRight){
            $small = $cLeft;
        }else{
            $small = $cRight;
        } 

        $userRank++;
        $rank = $this->rank;
        //dd($cLeft); exit;
        if($small >= $rank[$userRank]['point']){

            $user = User::find(Auth::user()->id);
            $user->rank = $userRank;
            $user->save();

            $data2 = new Wallet;
            $data2->user_id = Auth::user()->id;
            $data2->receipt = $rank[$userRank]['amount'];
            $data2->wType = 'rankWallet';
            $data2->remark = 'Rank Bonus #'.$userRank;
            $data2->save();
        }

        return null;
    }


   protected function slot(){
        $cLeft=User::myChildAmount(Auth::user()->id,1);
        $cRight=User::myChildAmount(Auth::user()->id,2);
        
/*
        if($cLeft<=$cRight){
            $small = $cLeft;
        }else{
            $small = $cRight;
        }
        
        $userSlot = Auth::user()->slot;
        $userSlot++;
        $slot = $this->slot;
        //dd($slot[$userSlot]); exit;
        if($small >= $slot[$userSlot]){

            $user = User::find(Auth::user()->id);
            $user->slot = $userSlot;
            $user->save();

            $data2 = new Wallet;
            $data2->user_id = Auth::user()->id;
            $data2->receipt = $slot[$userSlot]*.05;
            $data2->wType = 'matchingWallet';
            $data2->remark = 'Matching Bonus #'.$userSlot;
            $data2->save();

            //$this->generationBonusDist($user->placementId,$data2->receipt,'Matching');
        }
*/
        return ['lvTotal'=>$cLeft,'rvTotal'=>$cRight];
    }


    public function volume($no){
        if($no==1 || $no==2){
            $user = User::where('placementId',Auth::user()->id)->where('hand',$no)->first();
            if ($user) {
                return redirect()->route('volume',$user->id);
            }            
        }

        return redirect()->back();
    }

    public function volumeID($id){
        $member = User::find($id);
        if ($member) {
            return view('pages.volume',compact('member'));
        }
        return redirect()->back();
    }


    public function level()
    {
        $ids  = array(Auth::user()->id);
        //$ids  = array(2,3,30,31);
        $datas  = array();
        for($i=1;$i<6;$i++){
            if(!empty($ids)){
                $ids = User::whereIn('referralId',$ids)->pluck('id')->toArray();
                $datas[$i] = count($ids);
            }
        }

        return view('pages.lavelList',compact('datas'));
    }

    
    public function levelTree()
    {
        $member = User::find(Auth::user()->id);
        return view('pages.levelTree')->withMembers($member);
    }

    public function levelTreeId($id)
    {
        if($id < Auth::user()->id){
            return redirect()->back();
        }
        $member = User::find($id);
        return view('pages.levelTree')->withMembers($member);
    }



/*#################            ########################################  */

    public function sendMoneyAc(){
        $wallet = 'registerWallet';
        return view('wallet.sendMoneyAc',compact('wallet'));
    }

    public function sendMoneyAcPost(Request $request)
    {
        $this->validate($request, array(
            'username' => 'required|exists:users,username',
            'wType' => 'required',
            'remark' => 'nullable',
            'payment' => 'required|numeric',//|min:'.$this->withdrowAmt,
            )
        );

        if($this->balance(Auth::user()->id,$request->wType) < $request->payment ){
            Session::flash('warning','Sorry, Your Balance Less then'.$request->payment);
        }else{
            $data = new Wallet;
            $data->user_id = Auth::user()->id;
            $data->payment = $request->payment;
            $data->wType = $request->wType;
            $data->remark = 'Sent to ID# '.$request->username.' '.$request->remark;
            $data->save();

            $user = User::where('username',$request->username)->first();

            $data2 = new Wallet;
            $data2->user_id = $user->id;
            $data2->receipt = $request->payment;//$payble;
            $data2->wType = $request->wType;
            $data2->remark = 'Receipt Form ID# '.Auth::user()->username;
            $data2->save();

            Session::flash('success','Money Sent');
        }

        return redirect()->back();
    }


    protected function adminId($id){
        $parent = User::find($id);
        if($parent->admin == 1 ){
           Session::flash('adminId',$parent->id);// = $parent->id;
        }else{
            $this->adminId($parent->sponsorId);
        }
    }


    public function sendMoneyWw(Request $request)
    {
        $this->validate($request, array(
            'remark' => 'nullable',
            'payment' => 'required|numeric|min:'.$this->transferToWW,
            )
        );
/*
        $wallet_info = $this->wallets[$request->wType]['wid_d'];
        if($wallet_info>0){
            $last_tx = Wallet::where('wType',$request->wType)->where('user_id',Auth::user()->id)
                ->whereNotNull('payment')->latest()->first();
            if($last_tx){
                $last_tx_date= $last_tx->created_at;                
            }else{
                $last_tx_date= Auth::user()->created_at;
            }

            $today = Carbon::today()->subDay($wallet_info);

            if($last_tx_date > $today){
                //dd('Not Mature, wait '.$wallet_info.' dsys after last transfer.'); exit;
                Session::flash('warning','Not Mature, wait '.$wallet_info.' dsys after last transfer.');
                return redirect()->back();
            }
        }
        */

        if($request->wType == 'dailyWallet'){
            if($request->payment < Auth::user()->packeg->minWithdraw){
                Session::flash('warning','Minimum Withdraw amount '.Auth::user()->packeg->minWithdraw);
                return redirect()->back();
            }
            
        }

        if($this->balance(Auth::user()->id,$request->wType) < $request->payment ){
            Session::flash('warning','Sorry, Your Balance Less then $'.$request->payment);
        }else{
            //$remark = $request->paymentMethod.' : '.$request->accountNo;
            //$payble = $request->payment - ($request->payment/100)*10;
            $data2 = new Wallet;
            $data2->user_id = Auth::user()->id;
            //$data2->payment = round($payble);
            $data2->payment = $request->payment;
            $data2->remark = 'Withdraw '.$request->remark;
            $data2->wType = $request->wType;
            //$data2->admin_id = 1;//$request->paymentId;
            $data2->save();

            
            $data = new Wallet;
            $data->user_id = Auth::user()->id;
            $data->receipt = $request->payment;
            $data->remark = 'Withdraw - '.$request->remark;
            $data->wType = 'withdrawWallet';
            $data->save();

            Session::flash('success','Transfered to Withdraw');
        }
        return redirect()->back();
    }


    public function dailyToWW(){
        $amount = $this->totalBalance(Auth::user()->id,'dailyWallet');

        if($amount < Auth::user()->packeg->minWithdraw){
                Session::flash('warning','Sorry, Minimum Withdraw amount '.Auth::user()->packeg->minWithdraw);
                return redirect()->back();
            }            

            $data2 = new Wallet;
            $data2->user_id = Auth::user()->id;
            //$data2->payment = round($payble);
            $data2->payment = $amount;
            $data2->remark = 'Transfared to Withdraw';
            $data2->wType = 'dailyWallet';
            //$data2->admin_id = 1;//$request->paymentId;
            $data2->save();

            
            $data = new Wallet;
            $data->user_id = Auth::user()->id;
            $data->receipt = $amount;
            $data->remark = 'Transfared form dailyWallet';
            $data->wType = 'withdrawWallet';
            $data->save();

            Session::flash('success','Transfared to Withdraw');
        
        return redirect()->back();

    }

    public function withdrawBalance(Request $request)
    {
        $this->validate($request, array(
            'bankName' => 'required',
            'accountNo' => 'required',
            'remark' => 'nullable',
            'payment' => 'required|numeric|min:'.$this->withdrowAmt,
            )
        );

        if($request->wType == 'dailyWallet'){
            if($request->payment < Auth::user()->packeg->minWithdraw){
                Session::flash('warning','Sorry, Minimum Withdraw amount '.Auth::user()->packeg->minWithdraw);
                return redirect()->back();
            }            
        }else{
            if($request->payment < $this->withdrowAmt ){
                Session::flash('warning','Sorry, Minimum Withdraw amount '.$this->withdrowAmt.'.');
                return redirect()->back();
            }
        }

        if($request->wType == 'dailyWallet'){
            if($this->balance(Auth::user()->id,'dailyWallet') < $request->payment ){
                Session::flash('warning','Sorry, Your Balance Less then $'.$request->payment);
                return redirect()->back();
            }
        }else{
            if($this->widBalance(Auth::user()->id) < $request->payment ){
                Session::flash('warning','Sorry, Your Balance Less then $'.$request->payment);
                return redirect()->back();
            }
        }        

        
        $payble = $request->payment;
        //$payble = $request->payment - ($request->payment/100)*10;
        //$vat = $request->payment - $payble;
        //$remark = $request->bankName.': '.$request->accountNo.' Total: '.$request->payment.',10% Vat:'.$vat.' Payble: '.$payble.' '.$request->remark; 
        $remark = $request->bankName.': '.$request->accountNo.' '.$request->remark; 
        $data2 = new AdminWallet;
        $data2->user_id = Auth::user()->id;
        $data2->payment = $payble;//round($payble);
        //$data2->payment = $request->payment;
        $data2->remark = $remark;           
        //$data2->admin_id = 1;//$request->paymentId;
        $data2->save();

        
        $data = new Wallet;
        $data->user_id = Auth::user()->id;
        //$data->payment = round($payble);
        $data->payment = $request->payment;
        $data->remark = $remark;
        $data->wType = $request->wType;//'withdrawWallet';
        $data->adminWid = $data2->id;
        $data->save();

        $data3 = AdminWallet::find($data2->id);
        $data3->wallet_id = $data->id;
        $data3->save();

        Session::flash('success','Withdraw Processing, Please wait 24 hours');
        
        return redirect()->back();
    }
    
  



}
