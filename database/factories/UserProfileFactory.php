<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\UserProfile;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;

$factory->define(UserProfile::class, function (Faker $faker) {
    $phone = '96278' . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
    $faker->addProvider(new Xvladqt\Faker\LoremFlickrProvider($faker));
    $filepath = public_path('storage/user');
    if (!File::exists($filepath)) {
        File::makeDirectory($filepath, 0777, true);
    }

    return [
        'user_id' => factory(User::class)->create()->id,
        'fullname' => $faker->firstName . ' ' . $faker->lastName,
        'phone' => $phone,
        'image' => 'user/' . $faker->image($filepath, 600, 600, ['technics'], false),
        'birthdate' => ($faker->boolean(50)) ? $faker->date() : null,
        'is_active' => true,
    ];
});
