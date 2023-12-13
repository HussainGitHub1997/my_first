<?php

namespace App\services\crypt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AESServices
{
    public function upload(Request $request)
    {
        $originalName = $request->file->getClientOriginalName();
        $path = "public/uploads/" . $originalName;
        Storage::disk('local')->put($path, file_get_contents($request->file));
        return response()->json(['message' => 'File uploaded successfully', 'file_path' => $path]);
    }

    public function show($file_name)
    {
        //  $file=Storage::get('public/uploads/jlrK72Dss9cG2wlxu0GaNhTwNTmuzDltFYYJxnz7');
        $filePath = "public/uploads/" . $file_name;
        $data = Storage::get($filePath);
        $size = Storage::size($filePath);
        return response()->json(['File name' => "$file_name", 'file_size' => "$size  bytes"]);
    }


    public function encryption($file_name)
    {
        $filePath = "public/uploads/" . $file_name;
        if (Storage::exists($filePath)) {
            $data = Storage::get($filePath);
            $split = str_split($data, 2000);
            $array_size = count($split);
            echo " index 0 = " . strlen($split[0]);
            echo " arraySize = " . $array_size;
            $encryptionMethod = "AES-256-CBC";
            $secretKey = "ThisIsASecretKey123";
            $iv = '1234567891011121';
            for ($i = 0; $i < $array_size; $i++) {
                $encrypt_data[$i] = openssl_encrypt($split[$i], $encryptionMethod, $secretKey, 0, $iv,);
            }
            // Print_r($myArray);
            $string_data = json_encode($encrypt_data);
            file_put_contents("$file_name", $string_data);
            Storage::put("public/uploads/saved/$file_name", $string_data);
            echo asset('storage/public/uploads/saved' . "file name: $file_name");
            //Print_r($myArray);
        }
        else {
            return response()->json(['error' => 'File not found']);
        }
    }

    public function decription($file_name)
    {
        $decryptionMethod = "AES-256-CBC";
        $secretKey = "ThisIsASecretKey123";
        $iv = '1234567891011121';
        $encrypt_data = json_decode(file_get_contents($file_name), true);
        //    print_r ($arr2);
        $array_size = count($encrypt_data);
        for ($i = 0; $i < $array_size; $i++) {
            $data[$i] = openssl_decrypt($encrypt_data[$i], $decryptionMethod, $secretKey, 0, $iv,);
        }
        // Print_r($data);
        $decrypt_data = '';
        foreach ($data as $all) {
            $decrypt_data .= $all;
        }

        Storage::put("public/uploads/decrypt/$file_name", $decrypt_data);
        echo asset('storage/public/uploads/decrypt' . "file name: $file_name ");
        //print_r($text2);

    }
}
