<?php

declare(strict_types=1);

namespace Models;

use Core\Model;
use PDO;

class Category extends Model
{
    protected static string $table = 'category';

    /**
     * Категории для главной
     * @return array
     */
    public static function getIndexList(): array
    {
        $stmt = self::db()->prepare('
            SELECT
                c.id AS category_id,
                c.name AS category_name,
                a.id AS article_id,
                a.title,
                a.description,
                a.image,
                a.date
            FROM ' . self::table() . ' c
            INNER JOIN ' . ArticleCategory::table() . ' ac
                ON ac.category_id = c.id
            INNER JOIN ' . Article::table() . ' a
                ON a.id = ac.article_id
            WHERE (
                SELECT COUNT(*)
                FROM ' . ArticleCategory::table() . ' ac2
                INNER JOIN ' . Article::table() . ' a2
                    ON a2.id = ac2.article_id
                WHERE ac2.category_id = c.id
                  AND (
                      a2.date > a.date
                      OR (a2.date = a.date AND a2.id > a.id)
                  )
            ) < 3
            ORDER BY a.date DESC;
        ');

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach ($rows as $row) {
            $catId = $row['category_id'];

            if (!isset($data[$catId])) {
                $data[$catId] = [
                    'id' => $catId,
                    'name' => $row['category_name'],
                    'articles' => [],
                ];
            }

            $data[$catId]['articles'][] = [
                'id' => $row['article_id'],
                'title' => $row['title'],
                'description' => $row['description'],
                'image' => $row['image'],
                'date' => $row['date'],
            ];
        }

        return $data;
    }

    /**
     * Статьи категории
     * @param int $id
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public static function getArticles(int $id, int $page = 1, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = self::db()->prepare('
            SELECT p.*
            FROM ' . Article::table() . ' p
            JOIN ' . ArticleCategory::table() . ' pc ON pc.article_id = p.id
            WHERE pc.category_id = :category_id
            ORDER BY p.date DESC
            LIMIT ' . $perPage . ' OFFSET ' . $offset
        );

        $stmt->execute([
            'category_id' => $id
        ]);

        return $stmt->fetchAll();
    }

    /**
     * Кол-во статей в категории
     * @param int $id
     * @return int
     */
    public static function countArticles(int $id): int
    {
        $stmt = self::db()->prepare('
            SELECT COUNT(*) as cnt
            FROM ' . ArticleCategory::table() . '
            WHERE category_id = :category_id
        ');

        $stmt->execute([
            'category_id' => $id
        ]);

        return (int)$stmt->fetchColumn();
    }
}