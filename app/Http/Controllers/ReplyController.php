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
            $reply->addMedia(storage_path('tmp/uploads/' . $file))
                ->toMediaCollection($reply->media_collection);
        }

        return redirect()->route('reply.index');
    }

    public function create()
    {
        return view('create');
    }

    public function edit()
    {
        return view('edit');
    }

    public function update(Request $request, Reply $reply)
    {
        $reply->update($request->validate(['name' => 'required']));
        if ($request->input('document_file', [])) {
            if (!$reply->document_file || $request->input('document_file') !== $reply->document_file->file_name) {
                $reply->addMedia(storage_path('tmp/uploads/' . $request->input('document_file')))->toMediaCollection($reply->media_collection);
            }
        } elseif ($reply->document_file) {
            $reply->document_file->delete();
        }

        return redirect()->route('reply.index');
    }

    public function upload(Request $request)
    {
        $path = storage_path('tmp/uploads');

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
        $reply->clearMediaCollection($reply->media_collection);
        $reply->delete();

        session()->flash('message', 'Deleted');
        return redirect()->route('reply.index');
    }
}