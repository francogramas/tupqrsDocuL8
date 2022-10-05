<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class themeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $themes = array(
            ['id'=>1, 'theme'=>'tupqrs'],
            ['id'=>2, 'theme'=>'light'],
            ['id'=>3, 'theme'=>'dark'],
            ['id'=>4, 'theme'=>'cupcake'],
            ['id'=>5, 'theme'=>'bumblebee'],
            ['id'=>6, 'theme'=>'emerald'],
            ['id'=>7, 'theme'=>'corporate'],
            ['id'=>8, 'theme'=>'synthwave'],
            ['id'=>9, 'theme'=>'retro'],
            ['id'=>10, 'theme'=>'cyberpunk'],
            ['id'=>11, 'theme'=>'valentine'],
            ['id'=>12, 'theme'=>'halloween'],
            ['id'=>13, 'theme'=>'garden'],
            ['id'=>14, 'theme'=>'forest'],
            ['id'=>15, 'theme'=>'aqua'],
            ['id'=>16, 'theme'=>'lofi'],
            ['id'=>17, 'theme'=>'pastel'],
            ['id'=>18, 'theme'=>'fantasy'],
            ['id'=>19, 'theme'=>'wireframe'],
            ['id'=>20, 'theme'=>'black'],
            ['id'=>21, 'theme'=>'luxury'],
            ['id'=>22, 'theme'=>'dracula'],
            ['id'=>23, 'theme'=>'cmyk'],
            ['id'=>24, 'theme'=>'autumn'],
            ['id'=>25, 'theme'=>'business'],
            ['id'=>26, 'theme'=>'acid'],
            ['id'=>27, 'theme'=>'lemonade'],
            ['id'=>28, 'theme'=>'night'],
            ['id'=>29, 'theme'=>'coffee'],
            ['id'=>30, 'theme'=>'winter'],
        );
        DB::table('themes')->insert($themes);

    }
}
