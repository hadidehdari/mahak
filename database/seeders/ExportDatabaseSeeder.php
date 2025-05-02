<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ExportDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->exportTable('users');
        $this->exportTable('categories');
        $this->exportTable('creators');
        $this->exportTable('age_groups');
        $this->exportTable('videos');
        $this->exportTable('audio_books');
        $this->exportTable('pdfs');
        $this->exportTable('campaigns');
        $this->exportTable('activities');
        $this->exportTable('sliders');
        $this->exportTable('pages');
        $this->exportTable('options');
        
        $this->command->info('تمام داده‌ها با موفقیت به سیدر تبدیل شدند.');
    }
    
    /**
     * تبدیل داده‌های یک جدول به سیدر
     */
    private function exportTable($tableName)
    {
        $data = DB::table($tableName)->get();
        
        if ($data->isEmpty()) {
            $this->command->info("جدول {$tableName} خالی است.");
            return;
        }
        
        $seederContent = "<?php\n\n";
        $seederContent .= "namespace Database\\Seeders;\n\n";
        $seederContent .= "use Illuminate\\Database\\Seeder;\n";
        $seederContent .= "use Illuminate\\Support\\Facades\\DB;\n\n";
        $seederContent .= "class " . Str::studly($tableName) . "Seeder extends Seeder\n";
        $seederContent .= "{\n";
        $seederContent .= "    /**\n";
        $seederContent .= "     * Run the database seeds.\n";
        $seederContent .= "     */\n";
        $seederContent .= "    public function run(): void\n";
        $seederContent .= "    {\n";
        
        foreach ($data as $row) {
            $seederContent .= "        DB::table('{$tableName}')->insert([\n";
            
            foreach ((array) $row as $key => $value) {
                if (is_null($value)) {
                    $seederContent .= "            '{$key}' => null,\n";
                } elseif (is_bool($value)) {
                    $seederContent .= "            '{$key}' => " . ($value ? 'true' : 'false') . ",\n";
                } elseif (is_numeric($value)) {
                    $seederContent .= "            '{$key}' => {$value},\n";
                } else {
                    $seederContent .= "            '{$key}' => '" . addslashes($value) . "',\n";
                }
            }
            
            $seederContent .= "        ]);\n\n";
        }
        
        $seederContent .= "    }\n";
        $seederContent .= "}\n";
        
        $fileName = database_path("seeders/" . Str::studly($tableName) . "Seeder.php");
        File::put($fileName, $seederContent);
        
        $this->command->info("جدول {$tableName} با موفقیت به سیدر تبدیل شد.");
    }
}
