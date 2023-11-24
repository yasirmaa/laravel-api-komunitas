<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Resources\CommentResource;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentController extends Controller
{
    use HttpResponses, SoftDeletes;

    public function index()
    {
        $comments = Comment::latest()->get();

        return response()->json([
            'data' => $comments
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required',
        ]);

        $request['user_id'] = auth()->user()->id;

        $comment = Comment::create($request->all());

        return new CommentResource($comment);
    }

    public function update(Request $request, $id)
    {
        try {
            $comment = Comment::find($id);

            if (!$comment) {
                return $this->error(null, 'comment not found', 404);
            }

            $comment->update($request->only([
                'content'
            ]));

            return $this->success($comment, "Comment updated successfully", 200);
        } catch (Exception $e) {
            return $this->error(null, $e, 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $comment = Comment::find($id);

            if (!$comment) {
                return $this->error(null, 'comment not found', 404);
            }

            $comment->delete();

            return $this->success($comment, 'comment deleted successfully');
        } catch (Exception $e) {
            return $this->error(null, $e, 500);
        }
    }
}
