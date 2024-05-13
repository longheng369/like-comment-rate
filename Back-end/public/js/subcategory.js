// public/js/subcategory.js
document.addEventListener("DOMContentLoaded", function() {
    const categorySelect = document.querySelector("select[name='category_id']");
    const subCategorySelect = document.querySelector("select[name='sub_category_id']");

    categorySelect.addEventListener("change", function() {
        const categoryId = this.value;
        fetch(`/get-subcategories/${categoryId}`)
            .then(response => response.json())
            .then(subCategories => {
                subCategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                subCategories.forEach(subCategory => {
                    const option = document.createElement("option");
                    option.value = subCategory.id;
                    option.textContent = subCategory.name;
                    subCategorySelect.appendChild(option);
                });
            });
    });
});
