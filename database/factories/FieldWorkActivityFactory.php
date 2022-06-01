<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\FieldWorkActivity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Cviebrock\EloquentSluggable\Services\SlugService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FieldWorkActivity>
 */
class FieldWorkActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $project_name = strtolower($this->faker->word()).' '.strtolower($this->faker->word());
        $pic_name = strtolower($this->faker->firstName());
        return [
            'project_name' => $project_name,
            'description' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'pic_name' => $pic_name,
            'pic_position' => $this->faker->jobTitle(),
            'pic_email' => $pic_name.'@mail.com',
            'pic_phone_number' => $this->faker->numerify('#########'),
            'address' => $this->faker->address(),
            'geo_location' => $this->faker->latitude($min = -90, $max = 90).', '.$this->faker->longitude($min = -180, $max = 180),
            'start_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'end_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'link' => SlugService::createSlug(FieldWorkActivity::class, 'link', $project_name)
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        $employee = Employee::select("id");
        $team = $this->faker->randomElements($array = $employee->get()->pluck("id")->toArray(), $count = $this->faker->numberBetween($min = 1, $max = 5));
        return $this->afterCreating(function (FieldWorkActivity $fieldWorkActivity) use ($team) {
            $fieldWorkActivity->employees()->attach($team);
        });
    }
}
