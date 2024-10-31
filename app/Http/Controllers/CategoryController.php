<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Auth::user()->categories;
        $categories->sortByDesc('id');

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        $userCategories = $user
            ->categories()
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        $categories = $this->buildCategoriesArray($userCategories);

        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $data = $request->validated();
        $category->fill($data);
        $category->user_id = Auth::user()->id;

        $this->categoryRepository->save($category);

        return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        $userCategories = $user
            ->categories()
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        $categories = $this->buildCategoriesArray($userCategories);

        return view('categories.show', compact('category', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return $this->show($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->fill($request->all());

        $this->categoryRepository->save($category);

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->categoryRepository->deleteById((int) $category->id);

        return $this->index();
    }

    private function buildCategoriesArray(Collection $categories, int $level = 0): array
    {
        $result = [];

        foreach ($categories as $category) {
            $result[] = [
                'id' => $category->id,
                'name' => str_repeat('---', $level) . ($level !== 0 ? ' ' : '') . $category->name
            ];

            if ($category->children->isNotEmpty()) {
                $result = array_merge(
                    $result,
                    $this->buildCategoriesArray($category->children, $level + 1)
                );
            }
        }

        return $result;
    }
}
