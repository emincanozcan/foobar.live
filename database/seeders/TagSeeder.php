<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'PHP',
            'Laravel',
            'Symfony',
            'Javascript',
            'Vue.js',
            'React',
            'Angular',
            'C#',
            '.Net Core',
            'Entity Framework',
            'Microsoft Azure',
            'AWS',
            'Elixir',
            'Scala',
            'Kotlin',
            'Python',
            'Django',
            'React Native',
            'Flutter',
            'Docker',
            'Kubernetes',
            'Linux',
            'Vim',
            'Operating Systems',
            'Rust',
            'Go',
            'Java',
            'Spring',
            'Web Development',
            'Mobile Development',
        ];

        Tag::insert(
            collect($tags)
                ->map(fn ($tag) => ['name' => $tag])
                ->toArray()
        );
    }
}
