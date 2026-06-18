<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StorageController extends Controller
{
    /** Serve files from storage/app/public without requiring a public/storage symlink */
    public function show(Request $request, $path)
    {
        $file = storage_path('app/public/' . $path);
        if (!file_exists($file)) {
            abort(404);
        }
        return response()->file($file);
    }
}
