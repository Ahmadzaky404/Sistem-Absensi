<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => '$2y$12$bEyJCNqr.Xxr7VMoIOmNQO75wGBQxd.UvMFUBvAnGCe1O5mp4Aecm',
                'role' => 'admin',
                'created_at' => '2026-08-08 23:45:04',
                'updated_at' => '2026-08-09 00:22:10',
            ],
            [
                'id' => 3,
                'nama' => 'Rendika',
                'username' => 'rendika',
                'password' => '$2y$12$5c0P5nZ7XNaZFLO7dVT6je5VH4Egw.ghEie0S0ocIRKoe6FZZ1W7S',
                'role' => 'direktur_utama',
                'created_at' => '2026-08-08 23:56:34',
                'updated_at' => '2026-09-09 14:40:24',
            ],
            [
                'id' => 5,
                'nama' => 'Rully Rachdial',
                'username' => 'Rully',
                'password' => '$2y$12$AWxGmAiiqxW.lQ1J/tSc1eEYbYTbVD.h3eJv68MwxzlBsEi904OGy',
                'role' => 'direktur',
                'created_at' => '2026-08-08 23:58:46',
                'updated_at' => '2026-09-09 14:41:07',
            ],
            [
                'id' => 6,
                'nama' => 'Zanuardi Daniswara',
                'username' => 'zanuardi',
                'password' => '$2y$12$xNIaiLmBbn4y.LF3gLboZ.b5kYIocz8dOmRWAnldqEYEgBUBn9Mti',
                'role' => 'karyawan',
                'created_at' => '2026-08-08 23:59:27',
                'updated_at' => '2026-09-06 02:09:21',
            ],
            [
                'id' => 7,
                'nama' => 'Sri Lugina',
                'username' => 'sri',
                'password' => '$2y$12$4GwQhkWQjAg9iHavkueGVOvmzKtFhrlQeeE7n8UCY4wRZaFAe.p0q',
                'role' => 'karyawan',
                'created_at' => '2026-08-09 00:00:10',
                'updated_at' => '2026-08-09 00:00:10',
            ],
            [
                'id' => 8,
                'nama' => 'Aprilia',
                'username' => 'aprilia',
                'password' => '$2y$12$HQ5QGabBs4uAqr.0Fba18OyMK4gEehm6EJmP.awmdnYjcUdDfIpge',
                'role' => 'karyawan',
                'created_at' => '2026-08-09 00:00:51',
                'updated_at' => '2026-08-09 00:00:51',
            ],
            [
                'id' => 9,
                'nama' => 'Benny Utin R',
                'username' => 'Benny',
                'password' => '$2y$12$c6RdHq7sSvzWewlmjrhnh.lY/zt4mFlaOBg9i1pDruIoGhbvL3ut2',
                'role' => 'karyawan',
                'created_at' => '2026-08-09 00:03:24',
                'updated_at' => '2026-08-09 00:03:36',
            ],
            [
                'id' => 10,
                'nama' => 'Namora',
                'username' => 'namora',
                'password' => '$2y$12$SIOriVC1XP1uEwmX/3kEJOpZsGRMMK9/9h2lDh0PYABFRUYtQT4p2',
                'role' => 'karyawan',
                'created_at' => '2026-08-09 00:06:06',
                'updated_at' => '2026-09-06 02:08:55',
            ],
            [
                'id' => 11,
                'nama' => 'Erwin Kurniawan',
                'username' => 'awan',
                'password' => '$2y$12$PuNGwTImAmr6hXVSKbBZWeidfk18/B86tg1W0uLEMEUn5/UvXPo1C',
                'role' => 'karyawan',
                'created_at' => '2026-08-09 00:06:55',
                'updated_at' => '2026-09-06 02:08:18',
            ],
            [
                'id' => 12,
                'nama' => 'Arif Yulianto',
                'username' => 'Arif',
                'password' => '$2y$12$wDYOpi7nHyXP8NnoXmHP4.KLpVQbsvhk/otzMOOZz3cbHWa6vge2S',
                'role' => 'office_boy',
                'created_at' => '2026-08-09 00:07:29',
                'updated_at' => '2026-08-09 00:07:29',
            ],
            [
                'id' => 14,
                'nama' => 'Dedek Irawan',
                'username' => 'dedek',
                'password' => '$2y$12$vlBi8viR7mdBSH.SwQ9ID..PaKx8M3Na685ja86byiXNmsb/14QIK',
                'role' => 'karyawan',
                'created_at' => '2026-09-09 14:25:22',
                'updated_at' => '2026-09-09 14:25:22',
            ],
            [
                'id' => 15,
                'nama' => 'Yoga Pramudita',
                'username' => 'yoga',
                'password' => '$2y$12$yiajrdtgV6YvGpVc4.6Q4.5yma4DLWWckTYC241cHKHm/4GIH0.oq',
                'role' => 'direktur',
                'created_at' => '2026-09-10 14:08:39',
                'updated_at' => '2026-09-10 14:08:39',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['id' => $user['id']],
                $user
            );
        }
    }
}