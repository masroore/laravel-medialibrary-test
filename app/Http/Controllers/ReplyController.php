<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function index()
    {
        $replies = Reply::all();

        return view('index', compact('replies'));
    }

    public function store(Request $request)
    {
        $reply = Reply::create($request->validate(['name' => 'required']));

        foreach ($request->input('document_file', []) as $file) {
            $reply->addMedia(storage_path('tmp/' . $file))
                ->toMediaCollection($reply->media_collection_name);
        }

        return redirect()->route('reply.index');
    }

    public function create()
    {
        return view('create');
    }

    public function edit(Reply $reply)
    {
        return view('edit', compact('reply'));
    }

    public function update(Request $request, Reply $reply)
    {
        $reply->update($request->validate(['name' => 'required']));
        foreach ($request->input('document_file', []) as $file) {
            if (!$reply->attachmentExists($file)) {
                $reply->addMedia(storage_path('tmp/' . $file))
                    ->toMediaCollection($reply->media_collection_name);
            }
        }

        return redirect()->route('reply.index');
    }

    public function upload(Request $request)
    {
        $path = storage_path('tmp');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function destroy(Reply $reply)
    {
        $reply->clearMediaCollection($reply->media_collection_name);
        $reply->delete();

        session()->flash('message', 'Deleted');

        return redirect()->route('reply.index');
    }
}
