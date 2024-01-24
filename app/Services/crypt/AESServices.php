<?php

namespace App\services\crypt;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class AESServices
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['file', 'present'],
        ]);
        $user = $request->user();
        if ($user->role == 'admin') {
            $originalName = $request->file->getClientOriginalName();
            $path = "public/uploads/" . $originalName;
            Storage::disk('local')->put($path, file_get_contents($request->file));
            return response()->json(['message' => 'File uploaded successfully', 'file_path' => $path]);
        } else {
            return new AuthenticationException();
        }
    }

    public function combine_files(Request $request, $file_name)
    {
        $user = $request->user();
        if ($user->role == 'admin') {
            $files = Storage::files("public/uploads");
            $files = Arr::sort($files);
            $firstChunk = Arr::first($files);
            $remainderChunks = Arr::except($files, 0);
            $array_size = count($remainderChunks);
            $wholeFile = "public/merge_files/$file_name";
            Storage::disk('local')->put($wholeFile, Storage::disk('local')->get($firstChunk));
            foreach ($remainderChunks as $chunk) {
                Storage::disk('local')->append($wholeFile, Storage::disk('local')->get($chunk));
            }
            // Storage::deleteDirectory("public/uploads");
            return "the file merge sucssesfully";
        } else {
            return new AuthenticationException();
        }
    }


    public function show($file_name)
    {
        $filePath = "public/uploads/" . $file_name;
        $data = Storage::get($filePath);
        $size = Storage::size($filePath);
        return response()->json(['File name' => "$file_name", 'file_size' => "$size  bytes"]);
    }


    public function encryption(Request $request, $file_name)
    {
        $user = $request->user();
        if ($user->role == 'admin') {
            $filePath = "public/merge_files/$file_name";
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
                Storage::put("public/encrypt/$file_name", $string_data);
                echo asset('storage/public/encrypt' . "file name: $file_name");
                //Print_r($myArray);
            } else {
                return response()->json(['error' => 'File not found']);
            }
        } else {
            return new AuthenticationException();
        }
    }

    public function decription(Request $request, $file_name)
    {
        $user = $request->user();
        if ($user->role == 'admin') {
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

            Storage::put("public/decrypt/$file_name", $decrypt_data);
            echo asset('storage/public/decrypt' . "file name: $file_name ");
            //print_r($text2);
        } else {
            return new AuthenticationException();
        }
    }
}
