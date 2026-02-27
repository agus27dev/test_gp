<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Get categories by type (for AJAX dropdown).
     *
     * @param string $type
     * @return JsonResponse
     */
    public function getByType(string $type): JsonResponse
    {
        return $this->categoryService->handleGetCategoriesByType($type)->json();
    }
}
