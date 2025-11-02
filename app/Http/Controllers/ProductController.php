<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // 商品と季節を一緒に取得し、6件ごとにページネーション
        $products = Product::with('seasons')->paginate(6);

        return view('products.index', compact('products'));
    }

    // 商品検索処理（部分一致対応）
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Product::query();

        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $products = $query->get();

        return view('products.index', compact('products', 'keyword'));
    }

    // 商品追加ページを表示
    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    // 商品を保存
    public function store(StoreProductRequest $request)
    {
        // フォームリクエストでバリデーション済み
        $validated = $request->validated();

        // 画像を保存してパスを取得
        if ($request->hasFile('image')) {
            // storage/app/public/images/ に保存される
            // DBには "images/ファイル名.jpg" が入る
            $validated['image'] = $request->file('image')->store('images', 'public');
        } else {
            // デフォルト画像を指定
            $validated['image'] = 'images/banana.png';
        }

        // 商品を保存
        $product = Product::create([
            'name' => $validated['name'],          // 商品の名前
            'price' => $validated['price'],        // 値段
            'image' => $validated['image'],        // 画像ファイル名
            'description' => $validated['description'], // 商品説明
        ]);


        // 季節を紐づける（多対多リレーション）
        if (!empty($validated['seasons'])) {
            $product->seasons()->attach($validated['seasons']);
        }

        return redirect()->route('products.index')->with('success', '商品を登録しました！');
    }

    public function edit(Product $product)
    {
        // 商品に関連する季節を事前にロードしておくと便利
        $product->load('seasons');
        $seasons = Season::all();
        return view('products.edit', compact('product', 'seasons'));
    }

    public function update(UpdateProductRequest $request, $productId)
    {
        // 対象の商品を取得
        $product = Product::findOrFail($productId);

        // バリデーション済みデータを取得
        $validated = $request->validated();

        // 入力値を反映
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->description = $validated['description']; // 必須なのでそのまま代入

        // 画像がアップロードされた場合のみ更新
        if ($request->hasFile('image')) {
            // storage/app/public/images/ に保存される
            $path = $request->file('image')->store('images', 'public');
            $filename = basename($path); // ファイル名だけ取り出す
            $product->image = $filename; // DBにはファイル名だけ保存
        }

        // 保存
        $product->save();

        // 季節（多対多の中間テーブルを更新）
        if (!empty($validated['seasons'])) {
            $product->seasons()->sync($validated['seasons']);
        } else {
            $product->seasons()->detach();
        }

        // 一覧画面へリダイレクト
        return redirect()->route('products.index')->with('success', '商品を更新しました！');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました！');
    }

    public function show($id)
    {
        $product = Product::with('seasons')->findOrFail($id);
        $seasons = Season::all();

        return view('products.show', compact('product', 'seasons'));
    }
}
