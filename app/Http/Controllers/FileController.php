<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Files;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function processUpload(Request $request)
    {

        if (Auth::check()) {
            if (!is_numeric($request->expirytime) && !is_numeric($request->maxdownloads) && $request->expirytime>300 && $request->expirytime<=604800 )
                abort(400);
            $path = $request->file('filetoupload')->store('uploads');

            $expiry = new \DateTime();
            $expiry->modify('+ ' . $request->expirytime . ' seconds')->format('Y-m-d H:i:s');


            $file = new Files;
            $file->remaining_downloads = $request->maxdownloads;
            $file->expires_at = $expiry;
            $file->path = $path;
            $file->user_id = auth()->id();
            $file->filename = $request->file('filetoupload')->getClientOriginalName();
            $file->file_uuid = Str::uuid();
            $file->download_key = Str::uuid();
            $file->filesize = Storage::size($path);
            $file->save();
            echo 'ok';
        }
    }

    public function processDownload($fileuuid, $filekey)
    {
        $now = new \DateTime();
        $file = Files::where('file_uuid', '=', $fileuuid)->where('download_key', '=', $filekey)->firstOrFail();
        if ($file->expires_at <= $now && $file->remaining_downloads >= 1) {

            $file->remaining_downloads = $file->remaining_downloads - 1;
            $file->save();

            if ($file->remaining_downloads == 0) {
                $file->delete();
                return Storage::download($file->path, $file->filename);
            } elseif ($file->remaining_downloads > 0) {
                return Storage::download($file->path, $file->filename);
            }
        }
    }

    public function showDownloadPage($fileuuid, $filekey)
    {
        $now = new \DateTime();
        $file = Files::where('file_uuid', '=', $fileuuid)->where('download_key', '=', $filekey)->firstOrFail();
        if ($file->expires_at <= $now)
            return view("download", ['File' => $file]);
        else
            abort(404);
    }

    public function showUploadPage(Request $request)
    {
        $now = new \DateTime();

        if (Auth::check()) {
            $files = Files::where('user_id', '=', auth()->id())->orderBy('created_at', 'desc')->where('expires_at', '>', $now)->get();
        } else {
            $files = null;
        }
        return view("home", ['Files' => $files]);

    }

    public function userDeleteFile($fileuuid, Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        $File = Files::where('file_uuid', '=', $fileuuid)->firstOrFail();
        Storage::delete($File->path);
        $File->delete();
        return back();

    }

    public static function fileCleanup()
    {
        $now = new \DateTime();
        $Files = Files::where('expires_at', '<=', $now)->get();
        foreach ($Files as $File) {
            Storage::delete($File->path);
            $File->delete();
        }
    }


}
