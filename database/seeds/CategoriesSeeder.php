<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
             ['name'=>'Model', 'slug'=>'psychic'],
             ['name'=>'Medium','slug'=>'medium'],
             ['name'=>'Astrologer','slug'=>'astrologer'],
             ['name'=>'Fortune Teller','slug'=>'fortune-teller'],
             ['name'=>'Tarot Card Reader','slug'=>'tarot-card-reader'],
             ['name'=>'Clairvoyant','slug'=>'clairvoyant'],
             ['name'=>'Spiritual Healer','slug'=>'spiritual-healer'],
             
        ];
           
        
            
            
         

        
        for($i=0 ; $i < count($categories); $i++){
            DB::table('category')
                ->insert([
                    'name' => $categories[$i]['name'],
                    'slug' => $categories[$i]['slug']
                ]);

        }
        $colors = [
            '#F871A5',
            '#9759FF',
            '#9D9DFA',
            '#9DD96A',
            '#FFAB6E',
            '#4991E9',
            '#FFAB6E',

        ];
        foreach (\App\Models\Category::all() as $item){
            $image = new \App\Models\File();
            $image->path = $item->slug.'.png';
            $image->name = $item->name;
            $image->ext = 'png';
            $image->save();
            //$item->image()->save($image);
        }

        

     
    }
}
