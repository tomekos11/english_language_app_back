<?php

namespace Modules\Word\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Word\Entities\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::create([
            'name' => 'czesci ciala',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','czesci ciala.svg')),
        ]);

        Category::create([
            'name' => 'dom',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','dom.svg')),
        ]);

        Category::create([
            'name' => 'ekonomia',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','ekonomia.svg')),
        ]);

        Category::create([
            'name' => 'informatyka',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','informatyka.svg')),
        ]);

        Category::create([
            'name' => 'jedzenie',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','jedzenie.svg')),
        ]);

        Category::create([
            'name' => 'lotnictwo',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','lotnictwo.svg')),
        ]);

        Category::create([
            'name' => 'miasto',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','miasto.svg')),
        ]);

        Category::create([
            'name' => 'motoryzacja',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','motoryzacja.svg')),
        ]);

        Category::create([
            'name' => 'muzyka',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','muzyka.svg')),
        ]);

        Category::create([
            'name' => 'owoce i warzywa',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','owoce i warzywa.svg')),
        ]);

        Category::create([
            'name' => 'panstwa',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','panstwa.svg')),
        ]);

        Category::create([
            'name' => 'podroze',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','podroze.svg')),
        ]);

        Category::create([
            'name' => 'praca',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','praca.svg')),
        ]);

        Category::create([
            'name' => 'przedmioty uzytku codziennego',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','przedmioty uzytku codziennego.svg')),
        ]);

        Category::create([
            'name' => 'rosliny',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','rosliny.svg')),
        ]);

        Category::create([
            'name' => 'sport',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','sport.svg')),
        ]);

        Category::create([
            'name' => 'szkola',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','szkola.svg')),
        ]);

        Category::create([
            'name' => 'ubrania',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','ubrania.svg')),
        ]);

        Category::create([
            'name' => 'uczucia',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','uczucia.svg')),
        ]);

        Category::create([
            'name' => 'zawody',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','zawody.svg')),
        ]);

        Category::create([
            'name' => 'zwierzeta',
            'photo_url' => Storage::url('categories/'.str_replace(' ','_','zwierzeta.svg')),
        ]);


    }
}
