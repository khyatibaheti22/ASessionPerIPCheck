<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    
    public function index2(Request $request){
        echo 'in-this function prd';die;
    }
    public function index(Request $request){
        $ipAddress  = $request->ip();
        $sessionKey = 'session_'.$ipAddress;
        $showSession='';
        if(cache()->has($sessionKey)){
            $showSession = $ipAddress;
        }
        if($request->post()){
            $data = $request->all();
            
            $ipAddress  = $request->ip();
            $sessionKey = 'session_'.$ipAddress;
            if($request->session_type == 'termnew'){
                if(cache()->has($sessionKey)){
                    
                    cache()->forget($sessionKey);
                    cache()->put($sessionKey,true,now()->addMinutes(60));
                    return redirect()->back()->with('success',"Your session is successfully created.");
                }else{
                    return redirect()->back()->with('error','There is no previous session available. Please create a new session.');
                }
            }else if($request->session_type == 'term'){
                if(cache()->has($sessionKey)){
                    
                    cache()->forget($sessionKey);
                    return redirect()->back()->with('success',"Your session is successfully deleted.");
                }else{
                    return redirect()->back()->with('error','There is no previous session available. Please create a new session.');
                }
            }else{
                if(cache()->has($sessionKey)){
                    return redirect()->back()->with('error',"You can't create a new session, since already it has a previous one.");
                    
                    // return response()->json(['message'=>'Another session is already in progress.'],'403');
                }else{
                    cache()->put($sessionKey,true,now()->addMinutes(60));
                    return redirect()->back()->with('success',"Your session is successfully created.");
                }
            }
        }
        return view('test.index',compact('showSession'));
    }
}
