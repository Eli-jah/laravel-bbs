<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Api\Controller;
use App\Models\Link;
use APP\Transformers\LinkTransformer;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function index(Request $request, Link $link)
    {
        $links = $link->getAllCached();
        return $this->response->collection($links, new LinkTransformer());
    }
}
