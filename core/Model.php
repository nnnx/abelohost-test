<?php

declare(strict_types=1);

namespace Core;

use PDO;

abstract class Model
{
    protected static ?PDO $db = null;
    protected static string $table;

    protected static function db(): PDO
    {
        if (self::$db === null) {
            $config = require __DIR__ . '/../config/db.php';
            self::$db = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8",
                $config['user'],
                $config['pass']
            );
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$db;
    }

    public static function table(): string
    {
        return static::$table;
    }

    public static function all(): array
    {
        $stmt = static::db()->query("SELECT * FROM " . static::table());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = static::db()->prepare(
            "SELECT * FROM " . static::table() . " WHERE id = :id LIMIT 1"
        );

        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public static function create(array $data): bool
    {
        $fields = array_keys($data);
        $columns = implode(',', $fields);
        $placeholders = ':' . implode(', :', $fields);
        $sql = "INSERT INTO " . static::table() . " ($columns) VALUES ($placeholders)";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute($data);
    }

    public static function update(int $id, array $data): bool
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $set = implode(', ', $fields);
        $sql = "UPDATE " . static::table() . " SET $set WHERE id = :id";
        $data['id'] = $id;
        $stmt = static::db()->prepare($sql);
        return $stmt->execute($data);
    }
}