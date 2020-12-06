<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Client;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Supermarket;
use App\Models\Udid;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\HomeDataResource;
use App\Http\Resources\OfferResource;

class ProductController extends Controller
{
    //

    use GeneralTrait;

    public function __construct()
    {
        if (\request("Authorization")) {
            $this->middleware("auth:client-api");
        }
    }

    public function homedata(Request $request)
    {
        // Add Rate And Address Branch ++.
        // Change to Branch
        $supermarkets = Branch::where('status', 'active')->orderBy('priority', 'asc')->limit(10)->get();

        $offers = offer::where('status', 'active')->limit(4)->get();


        foreach ($supermarkets as $supermarket) {
            $supermarket->imagepath = asset('images/' . $supermarket->image);
            $supermarket->logopath = asset('images/' . $supermarket->logo_image);
            $supermarket->town = $supermarket->city->name;
        }

        foreach ($offers as $offer) {
            $offer->imagepath = asset('images/' . $offer->image);
        }

        if (auth("client-api")->check()) {
            $client = auth("client-api")->user();

            if ($client) {


                return ['data'=>[
                    'supermarkets' => HomeDataResource::collection($supermarkets),
                    'offers'       => OfferResource::collection($offers),
                ]];


            } else {

                return $this->returnError(305, 'there is no client found');
            }
        } else {
            Udid::where("body",$request->header("udid"))->updateOrCreate([
                "body" => $request->header("udid"),

            ]);

                return ['data'=>[
                    'supermarkets' => HomeDataResource::collection($supermarkets),
                    'offers'       => OfferResource::collection($offers),
                ]];
        }


    }

    public function productdetails(Request $request)
    {


        $product_id = $request->id;
        try {

            $product = Product::findOrFail($product_id);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "status" => "Product Not Found"
            ], 404);
        }
        $product->update(["views" => $product->views == null ? 1 : $product->views + 1]);


        $product_details = Product::where('id', $product_id)->select('id', 'name_' . app()->getLocale() . ' as name', 'arab_description as description', 'arab_spec as overview', 'price', 'offer_price', 'rate', 'points', 'exp_date', 'production_date')->first();


        $product_images = explode(',', $product->images);

        $favproduct = DB::table('client_product')->where('udid', $request->header("udid"))->where('product_id', $product_id)->first();

        $names = ['production_date', 'exp_date', 'measure', 'size'];

        $values = [$product->production_date, $product->exp_date, 'kilo', $product->size->value];

        $specifications = [];

        for ($i = 0; $i < count($names); $i++) {
            array_push($specifications, array('name' => $names[$i], 'value' => $values[$i]));
        }

        if (isset($favproduct)) {
            $product_details->favourite = 1;
        } else {
            $product_details->favourite = 0;
        }

        if ($product->flag == 1) {

            $offer_price = $product->offer_price;
            $price = $product->price;

            $product_details->offer = 1;
            $product_details->percentage = ($offer_price / $price) * 100;
        } else {
            $product_details->offer = 0;
        }

        $imagepaths = [];

        foreach ($product_images as $image) {
            array_push($imagepaths, asset('images/' . $image));
        }

        $product_details->imagepaths = $imagepaths;
        $product_details->image = $imagepaths[0];
        $product_details->ratings = $product->ratings;
        $product_details->reviews = $product->clientreviews()->select('client_id', 'name', 'review')->get();
        $product_details->specifications = $specifications;
        $product_details->category = $product->category->name_en;
        $product_details->supermarket = $product->supermarket->eng_name;
        $product_details->deliver_to = 'cairo';
        $product_details->delivery_time = '30 minutes';


        return $this->returnData(['product'], [$product_details]);


    }

    public function getproductsearch($value)
    {

        $type = intval($value);

        if (strlen($type) < 10) {
            $products = Product::where('arab_name', 'LIKE', '%' . $value . "%")->orWhere('eng_name', 'LIKE', '%' . $value . "%")->get();

            if (count($products) < 1) {
                if ($this->getCurrentLang() == 'ar') {
                    return $this->returnError('', 'ليس هناك منتج بهذا الاسم');
                }
                return $this->returnError('', 'there is no product found');
            } else {
                foreach ($products as $product) {

                    if ($this->getCurrentLang() == 'ar') {

                        $productarray =
                            [
                                'name' => $product->arab_name,
                                'description' => $product->arab_description,
                                'rate' => $product->rate,
                                'price' => $product->price,
                                'images' => $product->images,
                                'category' => $product->category->arab_name,
                                'vendor' => $product->vendor->arab_name
                            ];
                    } else {

                        $productarray =
                            [
                                'name' => $product->eng_name,
                                'description' => $product->eng_description,
                                'rate' => $product->rate,
                                'price' => $product->price,
                                'images' => $product->images,
                                'category' => $product->category->eng_name,
                                'vendor' => $product->vendor->eng_name
                            ];
                    }
                    $all_products [] = $productarray;
                }

                return $this->returnData('products', $all_products);
            }
        } else {
            $product = Product::where('barcode', $value)->first();

            if ($product) {
                if ($this->getCurrentLang() == 'ar') {

                    $productarray =
                        [
                            'name' => $product->arab_name,
                            'description' => $product->arab_description,
                            'rate' => $product->rate,
                            'price' => $product->price,
                            'images' => $product->images,
                            'category' => $product->category->arab_name,
                            'vendor' => $product->vendor->arab_name
                        ];
                } else {

                    $productarray =
                        [
                            'name' => $product->eng_name,
                            'description' => $product->eng_description,
                            'rate' => $product->rate,
                            'price' => $product->price,
                            'images' => $product->images,
                            'category' => $product->category->eng_name,
                            'vendor' => $product->vendor->eng_name
                        ];
                }
                return $this->returnData('product', $productarray);
            } else {
                return $this->returnError('', 'there is no product found');
            }


        }

    }

    public function filter()
    {
        $products = Product::where("branch_id", \request("branch_id"))->filter()->paginate();
        return ["success" => true, "products" => ProductResource::collection($products), "more" => $products->hasMorePages()];
    }
}
