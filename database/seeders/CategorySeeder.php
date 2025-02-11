<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private $mainCategories = [
        'Development',
        'Business',
        'Marketing',
        'Academy',
        'Office',
        'Engineering',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->mainCategories as $index => $categoryName) {
            $iconNumber = $index + 1;
            Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'icon' => 'frontend/assets/images/category_icon_' . $iconNumber . '.png',
                'image' => 'frontend/assets/images/category_img_' . $iconNumber . '.jpg',
            ]);
        }

        // Development subcategories
        $development = Category::where('slug', 'development')->first();
        $this->createSubcategories($development->id, [
            'Web Development',
            'Mobile Development',
            'Game Development',
        ]);

        // Business subcategories
        $business = Category::where('slug', 'business')->first();
        $this->createSubcategories($business->id, [
            'Entrepreneurship',
            'Management',
            'Finance',
        ]);

        // Marketing subcategories
        $marketing = Category::where('slug', 'marketing')->first();
        $this->createSubcategories($marketing->id, [
            'Digital Marketing',
            'Social Media Marketing',
            'Content Marketing',
        ]);

        // Academy subcategories
        $academy = Category::where('slug', 'academy')->first();
        $this->createSubcategories($academy->id, [
            'Science',
            'Math',
            'History',
            'Literature',
        ]);

        // Office subcategories
        $office = Category::where('slug', 'office')->first();
        $this->createSubcategories($office->id, [
            'Microsoft Office',
            'Google Workspace',
            'Productivity',
        ]);

        // Engineering subcategories
        $engineering = Category::where('slug', 'engineering')->first();
        $this->createSubcategories($engineering->id, [
            'Mechanical Engineering',
            'Electrical Engineering',
            'Civil Engineering',
            'Chemical Engineering',
        ]);
    }

    /**
     * Helper function to create subcategories
     */
    private function createSubcategories($parentId, array $subcategories)
    {
        static $shapeCounter = 1;

        foreach ($subcategories as $subcategory) {
            // Reset counter if it exceeds 3 (assuming we have shapes 1-3)
            if ($shapeCounter > 3) {
                $shapeCounter = 1;
            }

            Category::create([
                'name' => $subcategory,
                'slug' => Str::slug($subcategory),
                'icon' => 'frontend/assets/images/category_4_shapes_' . $shapeCounter . '.png',
                'image' => 'frontend/assets/images/category_img_' . $shapeCounter . '.jpg',
                'parent_id' => $parentId
            ]);

            $shapeCounter++;
        }
    }
}
