<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\User::class, 50)->create();
        
        $users->each(function(App\User $user) use ($users) {
            factory(App\Message::class)
                ->times(20)
                ->create([
                    'user_id' => $user->id,
                ]);
            $user->follows()->sync(
                $users->random(10)
            );
        });
    }
}
