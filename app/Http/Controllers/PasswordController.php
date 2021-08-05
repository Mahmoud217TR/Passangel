<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Password;

class PasswordController extends Controller
{
    //

    public function generate(){
        /* Old alternative way
         return Str::random(20); */

        // Better way
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!?<>{}()-_=+*/@#$%^&.,;:`~";
        $SA = "abcdefghijklmnopqrstuvwxyz";
        $CA = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $Num = "1234567890";
        $Sym = "!?<>{}()-_=+*/@#$%^&.,;:`~";
        $combination = substr(str_shuffle($chars),0,27).substr(str_shuffle($SA),0,1).substr(str_shuffle($CA),0,1).substr(str_shuffle($Num),0,1).substr(str_shuffle($Sym),0,2);
        return str_shuffle($combination);
    }

    public function advancedGenerate(){
        $request = request()->query();
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!?<>{}()-_=+*/@#$%^&.,;:`~";
        $SA = "abcdefghijklmnopqrstuvwxyz";
        $CA = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $Num = "1234567890";
        $Sym = "!?<>{}()-_=+*/@#$%^&.,;:`~";

        $SA_count = $request['SA'];
        $CA_count = $request['CA'];
        $Num_count = $request['Num'];
        $Sym_count = $request['Sym'];
        $Password_len = $request['len'];
        $R_count = $Password_len-($SA_count + $CA_count + $Num_count + $Sym_count);
        
        $combination = '';

        // SA Making
        $SA_len = strlen($SA);
        $tmp = $SA_count;
        
        do{
            $combination = $combination.substr(str_shuffle($SA),0,$tmp);
            $tmp = $tmp - $SA_len;
        }while($tmp > 0);

        // CA Making
        $CA_len = strlen($CA);
        $tmp = $CA_count;
        
        do{
            $combination = $combination.substr(str_shuffle($CA),0,$tmp);
            $tmp = $tmp - $CA_len;
        }while($tmp > 0);

        // Num Making
        $Num_len = strlen($Num);
        $tmp = $Num_count;
        
        do{
            $combination = $combination.substr(str_shuffle($Num),0,$tmp);
            $tmp = $tmp - $Num_len;
        }while($tmp > 0);

        // Sym Making
        $Sym_len = strlen($Sym);
        $tmp = $Sym_count;
        
        do{
            $combination = $combination.substr(str_shuffle($Sym),0,$tmp);
            $tmp = $tmp - $Sym_len;
        }while($tmp > 0);

        // Rest of Password Making
        $R_len = strlen($chars);
        $tmp = $R_count;
        
        do{
            $combination = $combination.substr(str_shuffle($chars),0,$tmp);
            $tmp = $tmp - $R_len;
        }while($tmp > 0);
        
        return '.'.str_shuffle($combination);
    }

    public function create(){
        if(auth()->guest()){
            abort('403');
        }else{
            $user = auth()->user();

            $data = request()->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255'],
                'username' => ['string', 'max:255'],
                'password' => ['required', 'string', 'confirmed'],
                'note' => ''
            ]);

            $instace = new Password;

            Password::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => $instace->encrypt(($data['password'])),
                'note' => $data['note'],
                'user_id' => $user->id,
            ]);
            
            return redirect('home');
        }
    }

    public function changeToken(){
        $user = auth()->user();
        $newToken = bin2hex(random_bytes(5));
        foreach($user->passwords as $p){
            $tmp = $p->decrypt($p->password);
            $p->password = $p->encryptWithToken($newToken,$tmp);
            $p->save();
        }
        $user->token = $newToken;
        $user->save();
        return $newToken;
    }

    
}
