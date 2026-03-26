<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    // Retourne toutes les images pour une date et un type
    public function getByDateThenType($date, $type)
    {
        $path = storage_path("app/public/images/$date/$type");

        if (!file_exists($path) || !is_dir($path)) {
            return response()->json([]); // aucun dossier => aucune image
        }

        $files = scandir($path);
        $images = [];

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;

            $images[] = [
                'url' => asset("storage/images/$date/$type/$file"), // lien public
                'title' => pathinfo($file, PATHINFO_FILENAME)
            ];
        }

        return response()->json($images);
    }

    // Affiche une image individuelle
    public function show($date, $filename)
    {
        $path = storage_path("app/public/images/$date/$filename");

        if (!file_exists($path)) {
            abort(404);
        }

        $mime = mime_content_type($path);
        return response()->file($path, ['Content-Type' => $mime]);
    }
}