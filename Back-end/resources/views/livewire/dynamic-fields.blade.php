<!-- dynamic-fields.blade.php -->
<div>
    <label for="category">Category:</label>
    <select wire:model="selectedCategory" id="category">
        <!-- Include options for categories -->
        <option value="">Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <label for="sub-category">Sub-category:</label>
    <select wire:model="selectedSubCategory" id="sub-category">
        <!-- Include options for sub-categories -->
        <option value="">Select Sub-category</option>
        @foreach($subCategories as $subCategory)
            <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
        @endforeach
    </select>

    <!-- Include any additional dynamic fields here -->
</div>
