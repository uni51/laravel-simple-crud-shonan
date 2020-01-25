<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $items = Item::orderBy('created_at', 'desc')->get();

        return view('items.index', [
            'items' => $items
        ]);
    }
}
