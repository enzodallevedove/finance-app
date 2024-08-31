<?php

namespace App\Interfaces;

use Exception;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface CategoryRepositoryInterface
{
    /**
     * @param int $id
     * @return Category
     *
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Category;

    /**
     * @param Category $category
     * @return Category
     *
     * @throws Exception
     */
    public function save(Category $category): Category;

    /**
     * @param int $id
     * @return bool
     *
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function deleteById(int $id): bool;
}
