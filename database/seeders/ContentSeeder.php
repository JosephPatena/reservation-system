<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('contents')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        \App\Models\Content::create([
            'text' => "<div class='mb-5 element-animate'>
            <h1>Welcome To RS Resort</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
          </div>"
        ]);

        \App\Models\Content::create([
            'text' => "<div class='heading-wrap text-center element-animate'>
            <h4 class='sub-heading'>Stay with Us</h4>
            <h2 class='heading'>Introduction</h2>
            <p class='mb-5'>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus illo similique natus, a recusandae? Dolorum, unde a quibusdam est? Corporis deleniti obcaecati quibusdam inventore fuga eveniet! Qui delectus tempore amet!</p>
          </div>"
        ]);

        \App\Models\Content::create([
            'text' => "<h2>Relax and Enjoy your Holiday</h2>
          <p class='lead mb-5'>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto quidem tempore expedita facere facilis, dolores!</p>",
            'link' => 'https://vimeo.com/channels/staffpicks/93951774'
        ]);

        \App\Models\Content::create([
            'text' => "<div class='heading-wrap  element-animate'>
              <h4 class='sub-heading'>Stay with Us</h4>
              <h2 class='heading'>Our Story</h2>
              <p class=''>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus illo similique natus, a recusandae? Dolorum, unde a quibusdam est? Corporis deleniti obcaecati quibusdam inventore fuga eveniet! Qui delectus tempore amet!</p>

              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus illo similique natus, a recusandae? Dolorum, unde a quibusdam est? Corporis deleniti obcaecati quibusdam inventore fuga eveniet! Qui delectus tempore amet!</p>

              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus illo similique natus, a recusandae? Dolorum, unde a quibusdam est? Corporis deleniti obcaecati quibusdam inventore fuga eveniet! Qui delectus tempore amet!</p>

            </div>"
        ]);

        \App\Models\Content::create([
            'phone' => '+ 1 332 3093 323'
        ]);
    }
}
