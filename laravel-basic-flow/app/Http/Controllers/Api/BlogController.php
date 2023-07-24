<?php

namespace App\Http\Controllers\Api;

use App\Events\BlogCreatedEvent;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        //
         $blogs = Blog::latest()->paginate(5)->through(fn($blog) => new BlogResource($blog));

        // $blogs = BlogResource::collection($blogs)->response()->getData(true);
        return response()->json([
            'message' => "Blog listed successfully",
              'data' => $blogs,
             'status' => 200
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBlogRequest $request) :  JsonResponse
    {
        //
        $blog = Blog::create($request->validated());

        if($request->has('image') && !empty($request->image)){
            $blog->addMediaFromRequest('image')->toMediaCollection('image');
        }

         return response()->json([
            'message' => "Blog created successfully",
              'data' => new BlogResource($blog),
             'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $blog) :  JsonResponse
    {
        //
         try {
            //code...
         $blog = Blog::findOrFail($blog);
         return response()->json([
            'message' => "Blog showed successfully",
              'data' => new BlogResource($blog),
             'status' => 200
        ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
            'message' => "Blog was not found ",
             'status' => 404
        ]);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog) :  JsonResponse
    {
        //
        try {
            //code...
        $blog = Blog::findOrFail($blog);

        $blog->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        if ($request->has('image') && !empty($request->image)) {

            DB::table('media')->where('model_id', $blog->id)->delete();
            $blog->addMediaFromRequest('image')->toMediaCollection('image');
        }


         return response()->json([
            'message' => "Blog Updated successfully",
              'data' => new BlogResource($blog),
             'status' => 200
        ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => "Blog was not found ",
             'status' => 404
             ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $blog) :  JsonResponse
    {
        //
        try {
            //code...
         $blog = Blog::findOrFail($blog);
         $blog->delete();

          return response()->json([
            'message' => "Blog delete successfully",
              'data' => new BlogResource($blog),
             'status' => 200
        ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => "Blog was not found ",
             'status' => 404
             ]);
        }
    }
}