<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Password;
use Illuminate\Support\Facades\File;

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

            $instance = new Password;

            Password::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => $instance->encrypt(($data['password'])),
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
            $p->password = Password::encryptWithToken($newToken,$tmp);
            $p->save();
        }
        $user->token = $newToken;
        $user->save();
        return $newToken;
    }

    public function makeBackup(){
        $user = auth()->user();
        $token = bin2hex(random_bytes(8));
        $filename = $user->id.bin2hex(random_bytes(12));
        $file_url = public_path().'\backups\passangel'.$filename.'.psgl';

        $pas = $user->passwords;
        foreach($pas as $p){
            $p -> password = $p->decrypt($p -> password);
        }
        $encPas = Password::encryptWithToken($token,$pas);

        $data = ['uid'=>$user->id.'#', 'username'=>$user->username.'#', 'token'=>$token.'#', 'backup_data'=>$encPas];

        File::put($file_url,$data);
        return ['name'=>$filename.'.psgl','url'=>asset('backups\passangel'.$filename.'.psgl'),'del'=>'backups\passangel'.$filename.'.psgl'];
    }

    public function removeBackup(){
        $file = request('del');
        File::delete($file);
    }

    public function loadBackup(){
        $content = request('content');
        $contents = explode('#',$content);
        $uid = $contents[0];
        $username = $contents[1];
        $token = $contents[2];
        $data = $contents[3];
        $passwords = Password::decryptWithToken($token,$data);
        $passwords = json_decode($passwords, true);
        if(auth()->user()->id != $uid || auth()->user()->username != $username){
            return 'Not_Authorized';
        }
        
        foreach($passwords as $p){
            $pas = Password::find($p['id']);
            if(is_null($pas)){
                $pas = new Password;
                $pas->user_id = $uid;
            }elseif($pas->user_id != $uid){
                continue;
            }
            $pas->name = $p['name'];
            $pas->username = $p['username'];
            $pas->email = $p['email'];
            $pas->note = $p['note'];
            $pas->password = $pas->encrypt($p['password']);
            $pas->save();
        }
        return 'Backup_Restored';
    }

    public function delete($id)
    {
        $user = auth()->user();
        $password = Password::findOrFail($id);
        if($user -> id != $password->user_id){
            abort('403');
        }else{
            $password->delete();
            return redirect('home');
        }
    }

    public function update()
    {
        $user = auth()->user();
        $pid = request('id');
        $password = Password::findOrFail($pid);
        if($user -> id != $password->user_id){
            abort('403');
        }else{
            $data = request()->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255'],
                'username' => ['string', 'max:255'],
                'password' => ['required', 'string', 'confirmed'],
                'note' => ''
            ]);
            $password->name = $data['name'];
            $password->email = $data['email'];
            $password->password = $password->encrypt($data['password']);
            $password->note = $data['note'];
            $password->save();
            return redirect('/show/'.$pid);
        }
    }

    public function changePassword(){
        $user = auth()->user();
        $data = request()->validate(['password' => ['required', 'string','min:8', 'confirmed'],]);
        $user-> password = Hash::make($data['password']);
        $user->save();
        return redirect('/home');
    }

    
}
