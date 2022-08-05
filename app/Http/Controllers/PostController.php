<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::when(request('searchKey'), function ($query) {
            $key = request('searchKey');
            $query->orWhere('title', 'like', '%' . $key . '%')
                ->orWhere('description', 'like', '%' . $key . '%');
        })->orderBy('updated_at', 'desc')->paginate(2);
        return view('home', compact('posts'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts,title',
            'description' => 'required|min:3',
            'image' => 'mimes:jpeg,png,jpg,gif|nullable'
        ]);

        if ($validator->fails())
            return redirect()->route('post.index')->withErrors($validator)->withInput();


        $validated = $validator->safe()->except(['_token']);

        if ($validated) {

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = uniqid() . '_' . $file->getClientOriginalName();
                Storage::disk('public')->put('image/' . $imageName, file_get_contents($file));
            }

            $post = new Post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->status = $request->status;
            $post->image = $imageName;

            $post->save();

            return redirect()->route('post.index')->with('success', 'New Todo is created successfully');
        }
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('show', compact('post'));
    }

    public function edit(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        return view('edit', compact('post'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts,title,' . $id,
            'description' => 'required|min:3',
            'image' => 'mimes:jpg,png,jpeg|nullable'
        ]);

        if($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $validated = $validator->safe()->except('_token');

        if($validated) {

            $post = Post::findOrFail($id);
            $post->title = $request->title;
            $post->description = $request->description;
            $post->status = $request->status;

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = uniqid() . '_' . $file->getClientOriginalName();

                Storage::disk('public')->put('image/' . $imageName, file_get_contents($file));
                if($post->image)
                    Storage::disk('public')->delete('image/'. $post->image);

            }


            $post->image = $request->image ? $imageName : $post->image;

            $post->update();

            return redirect()->route('post.index')->with('success', 'Post updated successfully!');
        }
    }

    public function destroy($id) {
        $post = Post::findOrFail($id);
        $post->delete();

        Storage::disk('public')->delete('image/' . $post->image);

        return redirect()->back();

    }
}
