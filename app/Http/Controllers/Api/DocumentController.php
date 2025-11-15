<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $query = Document::query();
        if ($type) $query->where('type', $type);
        $docs = $query->orderBy('created_at', 'desc')->get();
        return response()->json($docs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'type' => 'required|string'
        ]);

        $type = $request->input('type');
        $file = $request->file('file');

        $dir = 'uploads/' . ($type === 'publication' ? 'publications' : 'cvs');
        $path = $file->store($dir, 'public');

        $doc = Document::create([
            'title' => $request->input('title'),
            'type' => $type,
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return response()->json(['msg' => 'Uploaded', 'document' => $doc], 201);
    }

    public function destroy($id)
    {
        $doc = Document::find($id);
        if (!$doc) return response()->json(['msg' => 'Not found'], 404);

    
        if ($doc->path && Storage::disk('public')->exists($doc->path)) {
            Storage::disk('public')->delete($doc->path);
        }

        $doc->delete();
        return response()->json(['msg' => 'Deleted']);
    }
}
