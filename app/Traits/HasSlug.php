<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{

    public static function getSlug($name)
    {
        $base_slug = Str::slug($name);
        $slug = $base_slug;

        $n = 1;

        do {
            $find = self::where('slug', $slug)->first();

            if ($find !== null) {
                $slug = $base_slug . '-' . $n;
                $n++;
            }
        } while ($find !== null);

        return $slug;
    }
}
