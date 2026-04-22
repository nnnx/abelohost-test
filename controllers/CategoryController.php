<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Category;

class CategoryController extends Controller
{
    public function index(): void
    {
        $this->render('category/index', [
            'categories' => Category::getIndexList(),
        ]);
    }

    public function view(int $id): void
    {
        $category = Category::find($id);
        if ($category === null) {
            $this->error('Category not found', 404);
        }
        $currentPage = (int)($_GET['page'] ?? 1);
        if ($currentPage < 1) {
            $this->error('Page not found', 404);
        }
        $perPage = 3;
        $articles = Category::getArticles($id, $currentPage, $perPage);
        if (empty($articles)) {
            $this->error('Page not found', 404);
        }
        $total = Category::countArticles($id);

        $this->render('category/view', [
            'category' => $category,
            'articles' => $articles,
            'currentPage' => $currentPage,
            'totalPages' => ceil($total / $perPage),
        ]);
    }
}