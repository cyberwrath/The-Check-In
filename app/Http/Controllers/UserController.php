<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{ 
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        
        $developers = User::where('role', '=', 'friend')->paginate(15);
        return view('admin.developers', ['developers' => $developers]);
    }

    public function addDeveloper($id)
    {   
        $user = User::find($id);
        return view('admin.addDeveloperForm', compact('user'));
    }

    public function create(Request $request,  $id)
    {
        
        if($id == 0)
          { 
             $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required']
              ]);
            $emp = new User;
            $emp->name = $request->name;
            $emp->email = $request->email;
            $emp->phone = $request->phone;
            $emp->password = Hash::make(123456789);
            $emp->save();
            return redirect()->route('developers')->with('success', 'Form Data Has Been Inserted');
          }
          else
          {  
            
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
              ]);
             $emp = User::find($id);
             $emp->name = $request->name;
             $emp->email = $request->email;
             $emp->phone = $request->phone;
             $emp->password = Hash::make($request->password);
             $emp->update();
             return redirect()->route('developers')->with('success', 'Form Data Has Been Updated');
          }
          
   
          
   
         
    }

    public function deleteDeveloper($id)
        {
            User::find($id)->delete();
            return redirect()->route('Group', $id)->with('success','Developer removed successfully');
        }

    public function deleteAssignedFriend($user_id, $group_id)
        {
            DB::table('group_user')->where('user_id', $user_id)->where('group_id', $group_id)->delete();
            return redirect()->back()->with('success','Friend Removed Successfully');
        }
    
}
