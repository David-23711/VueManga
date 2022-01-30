<?php
 namespace App\repositories;
 use App\interfaces\categoryInterface;
 use App\Models\Category;
use Illuminate\Validation\Rule;

class categoryRepository implements categoryInterface{
   public function postCategory($category)
   {
     $category->validate([
      'category' => [Rule::unique('categories')],
     ]);
     $data = new Category;
     $data->category = $category->category;
     $data->save();
     return response(['message'=>'Category Added Successfully']);
   }

   public function getCategory()
   {
     return Category::when(request('search'),function($query){
       $query -> where('category','like','%'.request('search').'%');
     })->orderBy('created_at','desc')->get();
   }
    function updateCategory($id, $category)
   {
       $data = Category::find($id);
      $data->update([
       'category'=>$category['editCategory'],
     ]);
    return response(['message'=>'Updated Successfully']);
   }
   function deleteCategory($id)
   {
     $data= Category::find($id);
     $data->delete();
   }
   function categoryCount()
   {
     $data = Category::all()->count();
     return $data; 
   }
 }
?>