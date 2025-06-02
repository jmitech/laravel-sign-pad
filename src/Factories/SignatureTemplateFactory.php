<?php

namespace Jmitech\LaravelSignPad\Factories;

use Jmitech\LaravelSignPad\SignatureTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \App\SignatureTemplate
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class SignatureTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = SignatureTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucwords(implode(' ', $this->faker->words(rand(1, 3)))) . ' Signature Template',
            'config' => [
                "signaturePositions" => [
                    [
                        "signaturePage" => 1,
                        "signatureX" => rand(10, 100),
                        "signatureY" => rand(10, 200),
                        "signatureWidth" => rand(2, 6) * 100,
                        "signatureHeight" => rand(1, 3) * 100
                    ],
                    [
                        "signaturePage" => rand(1, 4),
                        "signatureX" => rand(10, 100),
                        "signatureY" => rand(10, 200),
                        "signatureWidth" => rand(2, 6) * 100,
                        "signatureHeight" => rand(1, 3) * 100
                    ]
                ],
                "textElements" => [
                    [
                        "text" => $this->faker->randomElement(['This is a test', 'Sample text element', 'Signature template text']),
                        "page" => rand(1, 4),
                        "X" => rand(10, 100),
                        "Y" => rand(10, 200),
                        "size" => $this->faker->randomElement([9, 12, 15]),
                        "style" => $this->faker->randomElement(['U', 'B', 'I', 'BU', 'BI', 'UI']),
                        "color" => $this->faker->randomElement(["blue", "red", "green", "black", "gray"]),
                    ]
                ],
                "dateElements" => [
                    [
                        "dateFormat" => $this->faker->randomElement(["Y-m-d H:i:s", "d/m/Y", "m-d-Y"]),
                        "page" => rand(1, 4),
                        "X" => rand(10, 100),
                        "Y" => rand(10, 200),
                        "size" => $this->faker->randomElement([9, 12, 15]),
                        "style" => $this->faker->randomElement(['U', 'B', 'I', 'BU', 'BI', 'UI']),
                        "color" => $this->faker->randomElement(["blue", "red", "green", "black", "gray"]),
                    ]
                ]
            ],
        ];
    }
}
