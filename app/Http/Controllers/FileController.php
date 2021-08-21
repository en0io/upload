<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Files;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // processUpload - process a file upload
    public function processUpload(Request $request)
    {
        // Before allowing an upload, we need to verify that the user is authenticated
        if (Auth::check()) {
            // Validate that the expiry time and  maximum number of downloads are valid
            // TODO: instead of hardcoding these values, they should be set in the .env file
            if (!is_numeric($request->expirytime) && !is_numeric($request->maxdownloads) && $request->expirytime > 300 && $request->expirytime <= 604800)
                abort(400);
            // Upload the file
            if ($path = $request->file('filetoupload')->store('uploads')) {
                // after the upload finishes, get the current timestamp and add the amount of time to expiry to it to get the expiration time
                $expiry = new \DateTime();
                $expiry->modify('+ ' . $request->expirytime . ' seconds')->format('Y-m-d H:i:s');

                $file = new Files; // create a new file object
                $file->remaining_downloads = $request->maxdownloads; //store the maximum number of downloads
                $file->expires_at = $expiry; // store expiration time
                $file->path = $path; // store the path of the file on the disk
                $file->user_id = auth()->id(); // store the ID of the user that owns the file
                $file->filename = $request->file('filetoupload')->getClientOriginalName(); // store the file's original name so we can download it as that later

                $file->file_uuid = Str::uuid(); // generate and store a UUID to use for the file
                $file->download_key = Str::uuid(); // generate and store another UUID to use as an auth key for downloads
                $file->filesize = Storage::size($path); // store the file size
                $file->save(); // commit file metadata to database
                echo 'ok'; // return "ok" if it uploads successfully
            } else {
                echo "err"; // return "err" if it fails TODO: make this return an error status code as well
            }
        } // if the user isn't logged in or has an invalid session, reject them
        else {
            abort(403); // abort if the user isn't logged in
        }
    }

    // processDownload - processes a request to download a file
    public function processDownload($fileuuid, $filekey)
    {
        $now = new \DateTime(); // get the current timestamp
        $file = Files::where('file_uuid', '=', $fileuuid)->where('download_key', '=', $filekey)->firstOrFail(); // query the database for a file that matches the file's UUID and download key
        if ($file->expires_at <= $now && $file->remaining_downloads >= 1) {
            //Only count a download if it is not owned by the current user
            if (auth()->id() != $file->user_id) {
                $file->remaining_downloads = $file->remaining_downloads - 1;
                $file->save();
            }
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
        $File = Files::where('file_uuid', '=', $fileuuid)->where('user_id', '=', auth()->id())->firstOrFail();
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
