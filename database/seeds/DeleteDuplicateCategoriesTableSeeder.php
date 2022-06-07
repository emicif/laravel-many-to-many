<?php

use Illuminate\Database\Seeder;
use App\Category;

class DeleteDuplicateCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $allCategory = Category::all();

        $categories = [];

        foreach($allCategory as $category){
            if (in_array($category->name, $categories)){

                $category->delete();
            }else {
                $categories[] = $category->name;
            }
        }
    }
}
