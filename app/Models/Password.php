<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'note',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    // Encryption & Decryption Functions

    public function encryptor($action, $string) {
        $output = FALSE;
        $encrypt_method = "AES-256-CBC";
        $secret_key = auth()->user()->token;
        $secret_iv  = auth()->user()->id;

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        //do the encryption given text/string/number
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } elseif ($action == 'decrypt') {
            //decrypt the given text/string/number
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    
    public function encrypt($data) {
        return urlencode(self::encryptor('encrypt', $data));
    }
    
    public function decrypt($data) {
        return self::encryptor('decrypt', urldecode($data));
    }

    public function encryptWithToken($token, $string) {
        $output = FALSE;
        $encrypt_method = "AES-256-CBC";
        $secret_key = $token;
        $secret_iv  = auth()->user()->id;

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        //do the encryption given text/string/number
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        
        return $output;
    }
}
