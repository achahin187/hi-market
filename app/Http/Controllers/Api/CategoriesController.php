<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //

    use generaltrait;

    public function index()
    {
        if ($this->getCurrentLang() == 'en') {
            $categories = Category::select('id','eng_name as name','image')->get();
        }
        else {
            $categories = Category::select('id','arab_name as name','image')->get();
        }

        return $this->returnData('categories',$categories);
    }
}
