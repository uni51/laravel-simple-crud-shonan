<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * 一覧表示
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $items = Item::orderBy('created_at', 'desc')->get();

        return view('items.index', [
            'items' => $items
        ]);
    }

    /**
     * 登録画面の表示
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request){
        return view('items.create');
    }

    /**
     * 登録処理
     *
     * @param ItemRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ItemRequest $request){
        $item = new Item();
        $item->name = $request->name;
        $item->age = $request->age;
        $item->sex = $request->sex;
        $item->memo = $request->memo;
        $item->save();
        return redirect()->action('ItemController@index');
    }

    /**
     * 詳細画面の表示
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id){
        $item = Item::findOrFail($id);

        return view('items.show')->with('item', $item);
    }
}
