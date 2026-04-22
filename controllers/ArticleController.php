<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Article;

class ArticleController extends Controller
{
    /**
     * @param int $id
     * @return void
     * @throws \SmartyException
     */
    public function view(int $id): void
    {
        $article = Article::find($id);
        if ($article === null) {
            $this->error('Article not found', 404);
        }

        Article::incrementViews($id);

        $this->render('article/view', [
            'article' => $article,
            'categories' => Article::getCategories($id),
            'similarArticles' => Article::getSimilarArticles($id)
        ]);
    }
}