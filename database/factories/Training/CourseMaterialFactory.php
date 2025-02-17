<?php

namespace Database\Factories\Training;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training\CourseMaterial>
 */
use App\Models\Training\Training;
use App\Models\Training\CourseMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseMaterialFactory extends Factory
{
    protected $model = CourseMaterial::class;

    public function definition()
    {
        $courseTitles = ['Laravel for Beginners: A Comprehensive Guide', 'Building RESTful APIs with Laravel', 'Mastering Laravel: Advanced Techniques and Best Practices', 'Laravel E-commerce Development: Create Your Online Store', 'Laravel and Vue.js: Building Modern Web Applications', 'Laravel Testing: Write Effective Tests for Your Applications', 'Laravel 9: The Complete Guide to Building Web Applications', 'Laravel Security: Protecting Your Applications from Vulnerabilities', 'Building Real-Time Applications with Laravel and Pusher', 'Laravel and Docker: Containerizing Your Applications', 'Laravel Blade Templating: Creating Dynamic Views', 'Laravel Authentication and Authorization: Securing Your App', 'Laravel and GraphQL: Building APIs with Laravel', 'Laravel Package Development: Create Your Own Packages', 'Laravel for Freelancers: Building Projects for Clients'];

        // Generate markdown content
        $materialContent = '## ' . $this->faker->realText() . "\n\n" . $this->faker->realText(300, true) . "\n\n" . "### Key Points\n" . '- ' . implode("\n- ", $this->faker->sentences(5)) . "\n\n" . "### Code Example\n" . "```php\n" . "<?php\n\n" . "echo 'Hello, World!';\n" . "```\n";

        return [
            'training_id' => $this->faker->numberBetween(1, Training::count()),
            'description' => $this->faker->sentence(),
            'material_name' => $this->faker->randomElement($courseTitles),
            'material_content' => $materialContent,
        ];
    }
}
