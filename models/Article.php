<?php

declare(strict_types=1);

namespace Models;

use Core\Model;
use PDO;

class Article extends Model
{
    protected static string $table = 'article';

    /**
     * Увеличить число просмотров
     * @param int $id
     * @return bool
     */
    public static function incrementViews(int $id): bool
    {
        $stmt = self::db()->prepare('
            UPDATE ' . self::$table . '
            SET views = views + 1
            WHERE id = :id
        ');

        return $stmt->execute([
            'id' => $id
        ]);
    }

    /**
     * Получить категории статьи
     * @param int $id
     * @return array
     */
    public static function getCategories(int $id): array
    {
        $stmt = self::db()->prepare('
            SELECT c.* FROM ' . Category::table() . ' c
            JOIN ' . ArticleCategory::table() . ' ac ON ac.category_id = c.id
            WHERE ac.article_id = :article_id
        ');

        $stmt->execute([
            ':article_id' => $id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Поиск похожих статей
     * @param int $id
     * @param int $limit
     * @return array
     */
    public static function getSimilarArticles(int $id, int $limit = 5): array
    {
        $stmt = self::db()->prepare('
            SELECT DISTINCT p.*
            FROM ' . self::table() . ' p
            JOIN ' . ArticleCategory::table() . ' pc ON pc.article_id = p.id
            WHERE pc.category_id IN (
                SELECT category_id
                FROM ' . ArticleCategory::table() . '
                WHERE article_id = :article_id
            )
            AND p.id != :article_id
            ORDER BY p.date DESC
            LIMIT ' . $limit . '
        ');

        $stmt->execute([
            'article_id' => $id,
        ]);

        return $stmt->fetchAll();
    }
}