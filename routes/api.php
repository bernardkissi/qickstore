<?php

// use App\Domains\Categories\Models\Category;
// use App\Domains\Categories\Resources\CategoryResource;
// use App\Domains\Products\Actions\ProductActions;

// use App\Domains\Products\Models\Product;
// use App\Domains\Products\Models\ProductVariation;
// use App\Domains\Products\Resource\ProductResource;
// use App\Domains\Products\Resource\SingleProductResource;
// use App\Domains\Products\Scopes\Filters\CategoryScope;
// use App\Domains\Stocks\Models\StockView;
// use Illuminate\Database\Eloquent\Builder;
use App\Domains\Cart\Services\Cart;
use App\Domains\Products\Product\Actions\ProductActions;
use App\Domains\Products\Product\Resource\ProductResource;
use App\Domains\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function () {
    // (new ProductActions())->uploadImage($request);

    // return CategoryResource::collection(Category::with('subcategories.subcategories')
    //     ->categories()
    //     ->ordered()
    //     ->get());

    // return  ProductResource::collection(Product::with('options', 'options.attributes', 'variations')->get());
    // return  Product::where('id', 1)->options()->get();

    // $scopes = [ 'category' => new CategoryScope() ];

    // $prod = Product::with('options', 'options.attributes', 'variations')
    //  ->withFilter($this->scopes)
    //  ->orderBy('created_at', 'desc')
    //  ->paginate(10);

    // return ProductResource::collection($prod);
    return ProductResource::collection((new ProductActions())->getProducts());
    // return (new ProductActions())->getProducts();
    // $product = Product::find(1);
        // $product->sku()->create(['code' => 'abc126', 'price' => 1000]);
        //
        //
        // return StockView::all();
});

Route::post('/test2', function (Request $request) {
    (new ProductActions())->createProduct($request);
    // $product =  Product::find(1);
    // (new AttributeActions())->storeFilters($product, $request->arr);
    // return (new OptionActions($request->arr))->storeOptions();
});


Route::post('cart', function (Request $request) {
    $class = config('modules.cart.vcart');
    $user = User::where('id', 1)->first();
    return (new $class(User::where('id', 1)->first()))->add($request->products);
});


Route::get('cart/items', function (Request $request) {
    $class = config('modules.cart.vcart');
    return (new $class(User::where('id', 1)->first()))->cartContents();
});
