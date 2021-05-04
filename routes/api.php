<?php


use App\Domains\Categories\Models\Category;
use App\Domains\Categories\Resources\CategoryResource;
use App\Domains\Products\Actions\ProductActions;
use App\Domains\Products\Models\Product;
use App\Domains\Products\Models\ProductVariation;
use App\Domains\Products\Resource\ProductResource;
use App\Domains\Products\Resource\SingleProductResource;
use App\Domains\Products\Scopes\Filters\CategoryScope;
use App\Domains\Stocks\Models\StockView;
use Illuminate\Database\Eloquent\Builder;
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
      // return ProductResource::collection((new ProductActions())->products());
        return (new SingleProductResource((new ProductActions())->product()));
        // $product = Product::find(1);
        // $product->sku()->create(['code' => 'abc126', 'price' => 1000]);
        //
        //
        // return StockView::all();
});


// Route::get('/product/{product:slug}', [ ])
