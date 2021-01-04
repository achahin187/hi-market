<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Branch;

class ProductDetailesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $branch = $this->branches->where("id",$request->supermarket_id)->first();
        return
            [
                "id" => $this->id,
                "name" => $this->name,
                "description" => $this->description,
                "overview" => $this->specs ?? "",
                "price" => $this->price ?? 0,
                "offer_price" => $this->offer_price ?? 0,
                "rate" => $this->rate ?? 0,
                "ratings" => $this->ratings ?? 0,
                "priority" => $this->priority ?? 0,
                "images" => asset("product_images/" . $this->images),
                "imagepaths" => [asset("product_images/" . $this->images)],
                "points" => $this->points ?? 0,
                "category_name" => $this->category->name ,
                "category_id" => $this->category_id ?? "",
                "flag" => $this->flag ?? 0,
                "supermarket_id" => (int) request()->get("supermarket_id"),
                "BranchName" => $this->getBranchName()->name,
                "favourite" => (int) (\DB::table("client_product")->where("product_id",$this->id)->where("udid",request()->header("udid"))->count() != 0),
                "percentage" => $this->price ? (int)(100 - (($this->offer_price / $this->price) * 100)) : 0,
                "category" => $this->category ?? "",
                "deliver_to" => $branch->city->name,
                "delivery_time" => request()->header('lang') == 'ar' ? 'دقيقة 30' : ' 30 minutes',
                "specs"=> [request()->header('lang') == 'ar' ? $this->arab_spec : $this->eng_spec],
                "branch_open_time"=>$branch->open_time ?? "",
                "branch_close_time"=>$branch->close_time ?? "",
                "cityname"=>$this->getBranchCity($branch),
            ];
    }

    private function getBranchName()
    {
        return Branch::Where('id', request("supermarket_id"))->first();
    }
    private function getBranchCity($branch)
    {
        if($branch && $branch->city)
        {
            return $branch->city->name;
        }else{
            return "";
        }
    }


}
