<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService extends BaseService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Handle get all categories.
     *
     * @return $this
     */
    public function handleGetAllCategories(): self
    {
        try {
            $categories = $this->categoryRepository->getAllCategories();

            return $this->setSuccess(true)
                        ->setResult($categories)
                        ->setMessage('List data kategori')
                        ->setCode(200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * Handle get categories by type.
     *
     * @param string $type
     * @return $this
     */
    public function handleGetCategoriesByType(string $type): self
    {
        try {
            $categories = $this->categoryRepository->getCategoriesByType($type);

            return $this->setSuccess(true)
                        ->setResult($categories)
                        ->setMessage('List kategori berdasarkan tipe')
                        ->setCode(200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
