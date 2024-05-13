<?php

namespace App\Livewire;

use Livewire\Component;

class DynamicFields extends Component
{
   

    public $selectedCategory;
    public $selectedSubCategory;
    public $dynamicFields = [];

    public function mount()
    {
        // Initialize with default values or perform any setup logic
    }

    public function updatedSelectedCategory($value)
    {
        // Fetch sub-category options based on the selected category
        $this->dynamicFields = []; // Clear previous dynamic fields
        $this->selectedSubCategory = null; // Reset selected sub-category
    }

    public function updatedSelectedSubCategory($value)
    {
        // Update dynamic fields based on the selected sub-category
    }

    public function render()
    {
        // Retrieve categories and sub-categories from your database
        $categories = \App\Models\Category::all();
        $subCategories = \App\Models\SubCategory::where('category_id', $this->selectedCategory)->get();

        return view('livewire.dynamic-fields', [
            'categories' => $categories,
            'subCategories' => $subCategories,
        ]);
    }
}
