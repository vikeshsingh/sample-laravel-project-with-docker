<?php
namespace App\Http\Controllers;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller {
    public function index(){ return Document::latest()->paginate(10); }
    public function store(Request $request){
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'file'  => ['required','file','max:5120']
        ]);
        $file = $data['file'];
        $key  = 'documents/'.Str::uuid().'.'.$file->getClientOriginalExtension();
        Storage::disk('s3')->put($key, file_get_contents($file), [
            'visibility' => 'private',
            'ContentType' => $file->getMimeType(),
        ]);
        $doc = Document::create([
            'title'      => $data['title'],
            's3_path'    => $key,
            'mime_type'  => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
        ]);
        return response()->json($doc, Response::HTTP_CREATED);
    }
    public function show(Document $document){
        $signedUrl = Storage::disk('s3')->temporaryUrl($document->s3_path, now()->addMinutes(10));
        return response()->json(['document' => $document, 'signed_url' => $signedUrl]);
    }
    public function update(Request $request, Document $document){
        $data = $request->validate(['title' => ['required','string','max:255']]);
        $document->update($data);
        return $document;
    }
    public function destroy(Document $document){
        Storage::disk('s3')->delete($document->s3_path);
        $document->delete();
        return response()->noContent();
    }
}
