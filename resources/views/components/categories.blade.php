@props(['categories'])

<div class="flex items-center justify-center gap-8">
    @foreach ($categories as $category)
    <x-category-item
        :text="$category->name"
        :image-path="'/images/' . strtolower($category->name) . '.webp'" />
    @endforeach
</div>