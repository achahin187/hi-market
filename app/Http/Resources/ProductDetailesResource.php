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
                "images" => asset("images/" . $this->images),
                "points" => $this->points ?? 0,
                "category_name" => $this->category->name ?? "",
                "category_id" => $this->category_id ?? "",
                "flag" => $this->flag ?? 0,
                "supermarket_id" => (int) request()->get("supermarket_id"),
                "BranchName" => $this->getBranchName()->name,
                "favourite" => \DB::table("client_product")->where("product_id",$this->id)->where("udid",request()->header("udid"))->count() != 0,
                "percentage" => $this->price ? (int)(100 - (($this->offer_price / $this->price) * 100)) : 0,
                "imagepaths" => $this->imagepaths ?? "default.png",
                "category" => $this->category ?? "",
                "deliver_to" => $this->deliver_to,
                "delivery_time" => $this->delivery_time,
                "specs"=>$this->specs,
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
