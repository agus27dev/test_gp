<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    /**
     * Get all categories.
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return Category::orderBy('name')->get();
    }

    /**
     * Get categories filtered by type.
     *
     * @param string $type
     * @return Collection
     */
    public function getCategoriesByType(string $type): Collection
    {
        return Category::where('type', $type)->orderBy('name')->get();
    }
}
