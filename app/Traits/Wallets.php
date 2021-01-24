<?php 
namespace App\Traits;
use App\AdminWallet;
use App\Wallet;
use App\EarnWallet;
use Carbon\Carbon;
use App\Packeg;
use App\User;

trait Wallets
{
    public $wallets =[
      //'currentWallet'=>['title'=>'Current Wallet','bg'=>'3','wid'=>1,'trns'=>0,'wid_d'=>0],
      'registerWallet'=>['title'=>'Joining Balance','bg'=>'4','wid'=>0,'trns'=>1,'wid_d'=>1],
      'dailyWallet'=>['title'=>'Daily Income Wallet','bg'=>'5','wid'=>1,'trns'=>0,'wid_d'=>0,'dailyWallet'=>1],
      'referralWallet'=>['title'=>'Referral Income Report','bg'=>'6','wid'=>1,'trns'=>0,'wid_d'=>0],
      'rankWallet'=>['title'=>'Rank Income Report','bg'=>'1','wid'=>1,'trns'=>0,'wid_d'=>0],
      'generationWallet'=>['title'=>'Generation Income Report','bg'=>'2','wid'=>1,'trns'=>0,'wid_d'=>0],
      'globalIncome'=>['title'=>'Global Income Report','bg'=>'3','wid'=>1,'trns'=>0,'wid_d'=>0],
      //'matchingWallet'=>['title'=>'Matching Wallet','bg'=>'1','wid'=>1,'trns'=>0,'wid_d'=>0],
    ];

    public $rank = [
      0=>['point'=>0, 'req'=>0, 'amount'=>0, 'prize'=>'', 'title'=>'No Rank'],
      1=>['point'=>5000, 'req'=>'Matching', 'amount'=>200, 'prize'=>'$200', 'title'=>'Premium'],
      2=>['point'=>10000, 'req'=>'Matching', 'amount'=>400, 'prize'=>'$400', 'title'=>'Pr. Executive'],
      3=>['point'=>20000, 'req'=>'Matching', 'amount'=>800, 'prize'=>'$800', 'title'=>'Pr. Star'],
      4=>['point'=>40000, 'req'=>'Matching', 'amount'=>1500, 'prize'=>'$1500', 'title'=>'Gold Star'],
      5=>['point'=>80000, 'req'=>'Matching', 'amount'=>5000, 'prize'=>'$5000(Car)', 'title'=>'Gold Diamond'],
    ];

    public $vip = [
      0=>['point'=>0, 'req'=>0, 'amount'=>0, 'prize'=>'', 'title'=>'No Star'],
      1=>['point'=>5, 'req'=>'1×5=5', 'amount'=>5, 'prize'=>'$5', 'title'=>'1 star'],
      2=>['point'=>25, 'req'=>'5×5=25', 'amount'=>10, 'prize'=>'$10', 'title'=>'2 star'],
      3=>['point'=>125, 'req'=>'25×5=125', 'amount'=>20, 'prize'=>'$20', 'title'=>'3 star'],
      4=>['point'=>625, 'req'=>'125×5=625', 'amount'=>40, 'prize'=>'$40', 'title'=>'4 star'],
      5=>['point'=>3125, 'req'=>'625×5=3125', 'amount'=>80, 'prize'=>'$80', 'title'=>'5 star'],
      6=>['point'=>15625, 'req'=>'3125×5=15625', 'amount'=>160, 'prize'=>'$160', 'title'=>'6 star'],
      7=>['point'=>78125, 'req'=>'15625×5=78125', 'amount'=>320, 'prize'=>'$320', 'title'=>'7 star'],
    ];

    public $slot = [
        0   => 0,
        1   => 12.5,
        2   => 25,
        3   => 50,
        4   => 100,
        5   => 200,
        6   => 500,
        7   => 1000,
        8   => 1500,
        9   => 2500,
        10  => 3600,
        11  => 5000,
        12  => 10000,
    ];    
    
    public function wallets() {
        $wallets = [];
        foreach($this->wallets as $key=>$item){
            $wallets[$key] = $item['title'];
        }
        return $wallets;
    }

    public function balance($id,$wType)
    {
        $receipt = Wallet::where('user_id',$id)->where('wType',$wType)->sum('receipt');
        $payment = Wallet::where('user_id',$id)->where('wType',$wType)->sum('payment');
        $balance = $receipt-$payment;
        return $balance;
    }

    public function widBalance($id)
    {
        $receipt = Wallet::where('user_id',$id)->whereIn('wType',['referralWallet','rankWallet','generationWallet','globalIncome','withdrawWallet'])->sum('receipt');
        //$receipt = Wallet::where('user_id',$id)->where('wType','!=','registerWallet')->sum('receipt');
        $payment = Wallet::where('user_id',$id)->where('wType','withdrawWallet')->sum('payment');
        $balance = $receipt-$payment;
        return $balance;
    }

    public function totalBalance($id,$wType)
    {
        $receipt = Wallet::where('user_id',$id)->where('wType',$wType)->sum('receipt');
        return $receipt;
    }

    public function allBalance($id){
        $balances = [];
            foreach ($this->wallets as $key=>$value) {
                if($value['wid_d']==1){
                $balances[$key] = ['balance'=>$this->balance($id,$key),'title'=>$value['title'],'bg'=>$value['bg']];
                }
            }
        return $balances;
    }

    public function allBalanceAdmin($id){
        $balances = [];
            foreach ($this->wallets as $key=>$value) {
                $balances[$key] = ['balance'=>$this->balance($id,$key),'title'=>$value['title'],'bg'=>$value['bg']];
            }
        return $balances;
    }

    public function acValidate($id)
    {
      $user = User::find($id);
      $expDate = Carbon::today()->addMonth($user->packeg->exp);

      return prettyDate($expDate);
    }

    public function listBalance($id,$wType)
    {
        $transaction = Wallet::where('user_id',$id)->where('wType',$wType)->latest()->take(10)->get();
        return $transaction;
    }


    public function totalReceive($id)
    {
        return Wallet::where('user_id',$id)->where('receive',1)->sum('receipt');
    }

    public function totalTransfar($id)
    {
        return Wallet::where('user_id',$id)->where('transfar',1)->sum('payment');
    }

    public function withdrawalRequest($user_id){
        return AdminWallet::where('user_id',$user_id)->sum('payment');
    }

    public function withdrawalRequestSuccess($user_id){
        return AdminWallet::where('user_id',$user_id)->where('confirm',1)->sum('payment');
    }

    /// **********************
    public function dailyBonusDist(){
      $users = User::all();
      foreach ($users as $user) {
        if($this->ckDailyIncomePercent($user) < $user->packeg->exp){
          $data2 = new Wallet;
          $data2->user_id = $user->id;
          $data2->receipt = $user->packeg->payment;
          $data2->wType = 'dailyWallet';
          $data2->remark = 'dailyWallet';
          $data2->save();
        }        
      }
    }

    public function ckDailyIncomePercent($user){
      $earn = $this->totalBalance($user->id,'dailyWallet');
      $earn = 100/$user->packeg->amount*$earn;
      return $earn;
    }

// *********************
    public function generationBonusDist($id,$bonus,$bonus_couse){      
        $gen = [ 1 => .02, 2 => .01, .03 => .01, 4 => .01, 5 => .005, 6 => .005, 7 => .005, 8 => .005, 9 => .005, 10 => .005, 11 => .004, 12 => .004, 13 => .004, 14 => .004, 15 => .004];

        $user = User::find($id);
        foreach ($gen as $key => $amt) {
          if(!$user){
            return true;
          }
          $amt = $bonus*$amt;
          $this->generationBonusSave($user->id,$amt,$bonus_couse,$user->username);
          //$user = User::find($user->placementId);
          $user = User::find($user->referralId);
        }        
    }

    protected function generationBonusSave($id, $amt,$bonus_couse,$mainId){
        $data = new Wallet;                
        $data->receipt = $amt;
        $data->user_id = $id;
        $data->wType = 'generationWallet';
        $data->remark = 'Generation Bonus('.$bonus_couse.')#'.$mainId;
        $data->save();
    }

// **************************************
    public function userArray()
    {
        $user = User::all();
        $users=array();
        foreach ($user as $data) {
            $users[$data->id]= $data->username.' '.$data->name;
        }
        return $users;
    }

    public function packArray()
    {
        $user = Packeg::all();
        $users=array();
        foreach ($user as $data) {
            $users[$data->id]= $data->title.' $'.$data->amount;
        }
        return $users;
    }

    public function percentage($amt,$percentage){
        return ($percentage / 100) * $amt;
    }
}