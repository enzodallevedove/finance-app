<?php

declare(strict_types=1);

namespace App\Repositories;

use Exception;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getById(int $id): Category
    {
        try {
            return Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function save(Category $category): Category
    {
        try {
            $result = $category->save();

            if (!$result) {
                throw new Exception('Could not save category.');
            }

            return $category;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): bool
    {
        $category = Category::findOrFail($id);

        try {
            return $category->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
