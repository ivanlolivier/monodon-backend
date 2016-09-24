<?php

use Illuminate\Database\Seeder;

class OAuthClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'id'                     => 1,
            'name'                   => 'Frontend',
            'secret'                 => 'm1uFo8tbPKUY8qoP1d2SJ60JCO0HyEvuX6f4x8Wb',
            'redirect'               => 'http://monodon.dev',
            'personal_access_client' => 0,
            'password_client'        => 1,
            'revoked'                => 0,
        ]);

    }
}
