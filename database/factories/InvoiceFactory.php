<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_number' => $this->faker->randomNumber(9),
            'invoice_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'product_id' => $this->faker->numberBetween(1, 10),
            'section_id' => $this->faker->numberBetween(1, 4),
            'commission_amount' => 20000,
            'discount' => 2000,
            'rate_vat' => 5,
            'value_vat' => 900,
            'total' => 0,
            'collection_amount' => 50000,
            'note' => 'note',
            'user_id' => '1',
            'status' => array_rand([1, 2, 0])
        ];
    }
}
