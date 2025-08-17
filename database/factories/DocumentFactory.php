<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory {
    public function definition(): array {
        return [
            'title' => $this->faker->sentence(3),
            's3_path' => 'documents/'.$this->faker->uuid.'.pdf',
            'mime_type' => 'application/pdf',
            'size_bytes' => $this->faker->numberBetween(1000,500000),
        ];
    }
}
