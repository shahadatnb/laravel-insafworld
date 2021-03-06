<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Traits\Wallets;
use App\Wallet;
use App\Packeg;
use App\User;
use Session;
use Auth;

class ProfileController extends Controller
{
    use Wallets;

    private $userReg = 15;
    private $userCom = 3;

    public function index(){
        $rank = $this->rank[Auth::user()->rank]['title'];
        return view('profile.profile',compact('rank'));
    }

    public function profileView($id){
        $user = User::find($id);
        if($user){
            $wallets=$this->allBalanceAdmin($user->id);
            $rank = $this->rank[$user->rank]['title'];
            return view('profile.profileView',compact('user','wallets','rank'));
        }
        return redirect()->back();
    }

    public function allMemberList()
    {
        $member = User::latest()->paginate(50);
        return view('admin.allMemberList')->withMembers($member);
    }

    public function editProfile(){
        $user_id = User::find(Auth::User()->id); 
        return view('profile.edit')->withUser($user_id);
    }


    public function newMember()
    {
        $packeg = $this->packArray();
        return view('auth.newMember',compact('packeg'));
    }


    public function newMemberPost(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|string|max:255',
            'username' => 'required|alpha_dash|max:30|unique:users',
            'email' => 'required|string|email|max:50',
            'password' => 'required|string|min:6|confirmed',
            'mobile' => 'required',
            'packeg' => 'required|exists:packegs,id',
            'referralId' => 'required|exists:users,id',
            //'placementId' => 'required|exists:users,id',
            'placementUsername' => 'required|exists:users,username',
            //'hand' => 'required|unique_with:users,placementId,hand',
            'hand' => 'required|unique_with:users,placementUsername,hand',
        ),[
            //'placementId.unique_with' => 'This referral Id already 5 member registered, please try another referral ID'
            'hand.unique_with' => 'This hand side is already used, please try another hand or another Placement',
        ]);

        $packAmount = Packeg::find($request->packeg);

        if($this->balance(Auth::user()->id,'registerWallet') >= $packAmount->amount){
            $placementUser = User::where('username',$request->placementUsername)->first();
            $data = new User;
            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->mobile = $request->mobile;
            $data->packeg_id = $request->packeg;
            $data->referralId = $request->referralId;
            $data->placementId = $placementUser->id;
            $data->placementUsername = $request->placementUsername;
            $data->hand = $request->hand;
            $data->password = bcrypt($request->password);
            $data->save();

            $data1 = new Wallet;
            $data1->user_id = $request->referralId;
            $data1->payment = $packAmount->amount;
            $data1->remark = 'New Member #'.$data->username;
            $data1->wType = 'registerWallet';
            $data1->save();

            $data2 = new Wallet;
            $data2->user_id = $request->referralId;
            $data2->receipt = $packAmount->amount*.08;
            $data2->remark = 'New Member #'.$data->username;
            $data2->wType = 'referralWallet';
            $data2->save();
            //$referralUser = User::find($request->referralId);
            $this->generationBonusDist($data->referralId,$packAmount->amount,'Refer');
            return redirect()->route('home');
        }else{
            Session::flash('warning','Sorry, Your Balance Less then '.$this->userReg);
            return redirect()->back()->withInput();
        }
    }

    

    public function updateProfile(Request $request){
        //dd($request); exit;
        $user_id = Auth::User()->id; 
        $this->validate($request, array(
            'name' => 'required|string|max:255',
            'pin' => 'required|numeric|digits:4',
            'username' => [
                'required','alpha_dash','max:30',
                Rule::unique('users')->ignore($user_id),
            ],
            'email' => [
                'required','email','max:50',
                Rule::unique('users')->ignore($user_id),
            ],
            /*'skypeid' => [
                'required','string','max:50',
                Rule::unique('users')->ignore($user_id),
            ],*/
            'mobile' => 'required|string|max:50'
        ));

                              
        $data = User::find(Auth::User()->id);
        
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->pin = $request->pin;
        $data->save();
        Session::flash('success','Successfully Save');

        return redirect()->route('profile');
    }

    public function changePass(){
        return view('profile.changePass');
    }

    public function changePhoto(Request $request){
        $this->validate($request, array(
        'photo' => 'mimes:jpg,jpeg,png|max:2000'
        ));

        $user_id = Auth::User()->id;                       
        $data = User::find($user_id);
        $image = $request->file('photo');
        if ($image) {
            $upload = 'public/upload/member';
            $filename = time() . '_' . $image->getClientOriginalName();
            $success = $image->move($upload, $filename);

            if ($success) {
                $data->photo = $filename;
                $data->save();
                Session::flash('success','Successfully Save');

                return redirect()->route('profile');
            } else {
                Session::flash('warning', "Image couldn't be uploaded.");
                return redirect()->route('profile');
            }
        }
    }
    
    public function changePassSave(Request $request){
        $this->validate($request, array(
            'CurrentPassword'=>'required|max:15',
            'password' => 'required|string|min:6|max:15|confirmed',
            ));
        //return Auth::user()->password.'<BR>'.Hash::make($request->CurrentPassword);

        if(Hash::check($request->CurrentPassword, Auth::user()->password )){
            $user_id = Auth::User()->id;                       
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request->password);
            $obj_user->save(); 
            return redirect()->route('profile');
        }else{
            return redirect()->route('changePass');
        }

    }
    
    public function changePassAdmin(Request $request){
        $this->validate($request, array(
            'user_id' => 'required',
            'password' => 'required|string|min:6|max:15',
        ));

        $obj_user = User::find($request->user_id);
        $obj_user->password = Hash::make($request->password);
        $obj_user->save(); 
        return redirect()->back();
    }
}
