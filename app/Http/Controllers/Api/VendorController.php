<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    use GeneralTrait;

    public function show($id)
    {
        $vendors = Vendor::whereHas("categories", function ($query) use ($id) {
            $query->where("categories.id", $id);
        })->get();
        return $this->returnData(["vendors"], [$vendors]);
    }

}
