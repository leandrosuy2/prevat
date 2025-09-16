<?php

namespace Database\Seeders;

use App\Models\TemplateCertifications;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateCertificatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            ['name' => 'Treinamento Padrão', 'content' => 'teste'],
            ['name' => 'Ambientação Hidro', 'content' => 'teste'],
            ['name' => 'Brigada de Incendio', 'content' => 'teste'],
        ];

        foreach ($templates as $template) {
            TemplateCertifications::create([
                'name' => $template['name'],
                'content' => $template['content']
            ]);
        }
    }
}
