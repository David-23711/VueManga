<?php
 namespace App\repositories;
 use App\interfaces\categoryInterface;
 use App\Models\category;
 class categoryRepository implements categoryInterface{
   public function getCategory()
   {
     dd('working');
   }
 }
?>