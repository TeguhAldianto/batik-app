<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Model yang difactory-kan.
     */
    protected $model = Product::class;

    /**
     * Define default state model.
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->sentence(3); // contoh: "Kemeja Lasem Premium"
        $category = $this->faker->randomElement([
            'kain_batik',
            'kemeja_pria',
            'dress_wanita',
        ]);

        // Size disesuaikan kategori
        $size = match ($category) {
            'kain_batik'   => '200 x 115 cm',
            'kemeja_pria'  => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'dress_wanita' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'All Size']),
            default        => 'All Size',
        };

        return [
            'name'        => $name,
            'slug'        => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(100, 999),
            'category'    => $category,
            'size'        => $size,
            'price'       => $this->faker->numberBetween(150_000, 1_200_000), // unsignedBigInteger
            'stock'       => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->paragraph(),
            'image'       => null, // nanti bisa diisi path image beneran
            'is_active'   => true,
            'weight'      => $this->faker->numberBetween(200, 900), // gram (lihat migration add_weight)
        ];
    }
}
