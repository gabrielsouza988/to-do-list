<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{ItemsTask, Task};

class ItemsTaskFactory extends Factory
{
    protected $model = ItemsTask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'task_id' => Task::factory()->create()->id,
            'task' => $this->faker->text(20),
            'date_execution' => $this->faker->date(),
            'status' => '0'
        ];
    }
}
