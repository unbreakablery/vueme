<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\File;
use Illuminate\Console\Command;

class InsertCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $data = [
            [
                'name' => 'Asian',
                'slug' => 'asian',
                'path' => 'images/category/asian.png',
                'count' => 153,
            ],
            [
                'name' => 'BBW',
                'slug' => 'bbw',
                'path' => 'images/category/bbw.png',
                'count' => 234,
            ],
            [
                'name' => 'Blonde',
                'slug' => 'blonde',
                'path' => 'images/category/blonde.png',
                'count' => 342,
            ],
            [
                'name' => 'Brunette',
                'slug' => 'brunette',
                'path' => 'images/category/brunette.png',
                'count' => 342,
            ],
            [
                'name' => 'Actresses',
                'slug' => 'actresses',
                'path' => 'images/category/actresses.png',
                'count' => 342,
            ],
            [
                'name' => 'Instagram Models',
                'slug' => 'instagram-models',
                'path' => 'images/category/instagram-models.png',
                'count' => 342,
            ],
            [
                'name' => 'Female Models',
                'slug' => 'female-models',
                'path' => 'images/category/female-models.png',
                'count' => 153,
            ],
            [
                'name' => 'Male Models',
                'slug' => 'male-models',
                'path' => 'images/category/male-models.png',
                'count' => 234,
            ],
            [
                'name' => 'Fitness Models',
                'slug' => 'fitness-models',
                'path' => 'images/category/fitness-models.png',
                'count' => 342,
            ],
            [
                'name' => 'Redheads',
                'slug' => 'redheads',
                'path' => 'images/category/redheads.png',
                'count' => 153,
            ],
            [
                'name' => 'Ebony',
                'slug' => 'ebony',
                'path' => 'images/category/ebony.png',
                'count' => 234,
            ],
            [
                'name' => 'Foot Models',
                'slug' => 'foot-models',
                'path' => 'images/category/foot-models.png',
                'count' => 342,
            ],
            [
                'name' => 'Dancers',
                'slug' => 'dancers',
                'path' => 'images/category/dancers.png',
                'count' => 342,
            ],
            [
                'name' => 'Cosplay',
                'slug' => 'cosplay',
                'path' => 'images/category/cosplay.png',
                'count' => 342,
            ],
        ];

        $categories = Category::all();
        $cont = 0;
        foreach ($data as $value) {
            if (isset($categories[$cont])) {
                $category = $categories[$cont++];
                $category->name = $value['name'];
                $category->slug = $value['slug'];
                $category->description = $category->color = null;
                $category->save();
                if ($file = $category->image) {
                    $file->delete();
                }

                $pathinfo = pathinfo($value['path']);
                $file = new File();
                $file->name = $pathinfo['basename'];
                $file->ext = $pathinfo['extension'];
                $file->path = $value['path'];
                $category->image()->save($file);
            } else {
                $category = new Category();
                $category->name = $value['name'];
                $category->slug = $value['slug'];
                $category->save();
                $pathinfo = pathinfo($value['path']);
                $file = new File();
                $file->name = $pathinfo['basename'];
                $file->ext = $pathinfo['extension'];
                $file->path = $value['path'];
                $category->image()->save($file);
            }
        }
    }
}
