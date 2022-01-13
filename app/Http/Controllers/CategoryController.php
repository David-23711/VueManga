<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Http\Requests\StorecategoryRequest;
use App\Http\Requests\UpdatecategoryRequest;
use App\interfaces\categoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected categoryInterface $categoryInterface;
    
    public function __construct(categoryInterface $categoryInterface)
    {
        $this->categoryInterface = $categoryInterface;
    }

    public function index()
    {
       return $this->categoryInterface->getCategory();
    }

}
