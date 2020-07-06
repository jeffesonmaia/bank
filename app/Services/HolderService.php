<?php

namespace App\Services;

use App\Models\Holder;

class HolderService
{
    public function getOrCreate(string $email, string $name): Holder
    {
        $holder = Holder::where('email', $email)->first();
        if (!$holder) {
            $holder = Holder::create([
                'email' => $email,
                'name' => $name,
            ]);

            $holder->save();
        }

        return $holder;
    }
}
