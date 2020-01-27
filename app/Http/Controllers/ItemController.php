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
    public function index(Request $request)
    {
        /* ローカルスコープを利用することとした為、コメントアウト
        $query = Item::query();

        if(isset($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if(isset($request->sex)){
            $query->where('sex', $request->sex);
        }

        if(isset($request->memo)){
            $query->where('memo', 'like', '%'.$request->memo.'%');
        }

        $items = $query->orderBy('created_at', 'desc')->get();
        */

        // ローカルスコープを使用する場合、例えばそれがscopeNameFilterという名前であった場合、
        // 名前の先頭に付けたscopeは省略する必要があります
        $items = Item::nameFilter($request->name)
            ->sexFilter($request->sex)
            ->memoFilter($request->memo)
            ->orderBy('created_at', 'desc')
            ->paginate(3)
            ->appends($request->all()); // ページネーションに検索条件(リクエストのパラメーター）を引き継がせる

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
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id){
        $item = Item::findOrFail($id);

        return view('items.show')->with('item', $item);
    }

    /**
     * 編集画面の表示
     *
     * @param String $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(String $id){
        return view('items.edit')->with('item', Item::findOrFail($id));
    }

    /**
     * 編集処理
     *
     * @param ItemRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ItemRequest $request, string $id){
        $item = Item::findOrFail($id);
        /*
         * fill($request->all())とすることで、更新するカラム名をひとつひとつ指定しなくて済んでいます。
         * ただし、fill()を使う場合は、更新しても良いカラム名をモデルの$fillableで指定しておく必要があります。
         */
        $item->fill($request->all())->save();
        return redirect()->route('index');
    }

    /**
     * 削除確認画面の表示
     *
     * @param Item $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Item $item){
        return view('items.delete')->with('item', $item);
    }

    /**
     * 削除処理
     *
     * @param Item $item
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Item $item){
        $item->delete();
        return redirect()->route('index');
    }
}
