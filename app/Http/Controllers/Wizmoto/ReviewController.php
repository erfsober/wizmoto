<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Provider;
use Illuminate\Http\Request;

class ReviewController extends Controller {
    public function store ( Request $request ) {
        $request->validate([
                               'stars' => 'required|integer|min:1|max:5' ,
                               'comment' => 'nullable|string|max:1000' ,
                           ]);
        $type = $request->input('type');
        $id = $request->input('id');
        $model = null;
        if ( $type === 'blog' ) {
            $model = BlogPost::findOrFail($id);
        }
        elseif ( $type === 'provider' ) {
            $model = Provider::findOrFail($id);
        }
        $model->reviews()
              ->create([
                           'name' => $request->name ,
                           'email' => $request->email ,
                           'stars' => $request->stars ,
                           'comment' => $request->comment ,
                       ]);

        return back()->with('success' , 'Review added successfully.');
    }
}
