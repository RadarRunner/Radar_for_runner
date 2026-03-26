<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // Retourne toutes les images pour une date et un type
    public function getByDateThenType($date, $type)
    {
        $path = "images/$date/$type";

        $files = Storage::disk('s3')->files($path);

        $images = [];

        foreach ($files as $file) {
            $images[] = [
                'url' => Storage::disk('s3')->url($file),
                'title' => pathinfo($file, PATHINFO_FILENAME),
            ];
        }

        return response()->json($images);
    }

    // Upload une image dans le bucket
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image'],
            'date' => ['required'],
            'course_type' => ['required'],
        ]);

        $path = $request->file('image')->store(
            'images/' . $request->date . '/' . $request->course_type,
            's3'
        );

        return response()->json([
            'message' => 'Image ajoutée',
            'url' => Storage::disk('s3')->url($path),
            'title' => pathinfo($path, PATHINFO_FILENAME),
        ]);
    }
}
