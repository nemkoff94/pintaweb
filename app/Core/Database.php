<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

final class Database
{
    private static ?PDO $connection = null;

    public static function connection(array $config): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $databasePath = $config['database']['path'];
        $directory = dirname($databasePath);

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (! file_exists($databasePath)) {
            touch($databasePath);
        }

        $pdo = new PDO('sqlite:' . $databasePath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->exec('PRAGMA foreign_keys = ON');

        self::initialize($pdo);
        self::$connection = $pdo;

        return self::$connection;
    }

    private static function initialize(PDO $pdo): void
    {
        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                login TEXT NOT NULL UNIQUE,
                password_hash TEXT NOT NULL,
                created_at TEXT NOT NULL
            )'
        );

        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS media_assets (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                file_name TEXT NOT NULL,
                original_name TEXT NOT NULL,
                relative_path TEXT NOT NULL UNIQUE,
                mime_type TEXT NOT NULL,
                size_bytes INTEGER NOT NULL,
                created_at TEXT NOT NULL
            )'
        );

        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS taps (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                style TEXT NOT NULL,
                abv REAL NOT NULL,
                price_store_liter REAL NOT NULL,
                price_bar_half REAL NOT NULL,
                image_path TEXT,
                is_on_tap INTEGER NOT NULL DEFAULT 0,
                created_at TEXT NOT NULL,
                updated_at TEXT NOT NULL
            )'
        );

        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS events (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                announce TEXT NOT NULL,
                description TEXT NOT NULL,
                cover_image_path TEXT,
                event_at TEXT NOT NULL,
                created_at TEXT NOT NULL,
                updated_at TEXT NOT NULL
            )'
        );

        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS promotions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                announce TEXT NOT NULL,
                description TEXT NOT NULL,
                cover_image_path TEXT,
                created_at TEXT NOT NULL,
                updated_at TEXT NOT NULL
            )'
        );

        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS news (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                content TEXT NOT NULL,
                cover_image_path TEXT,
                created_at TEXT NOT NULL,
                updated_at TEXT NOT NULL
            )'
        );

        $statement = $pdo->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
        $statement->execute([
            ':login' => 'admin',
        ]);

        if ((int) $statement->fetchColumn() === 0) {
            $insert = $pdo->prepare(
                'INSERT INTO users (login, password_hash, created_at)
                VALUES (:login, :password_hash, :created_at)'
            );

            $insert->execute([
                ':login' => 'admin',
                ':password_hash' => password_hash('52525647', PASSWORD_DEFAULT),
                ':created_at' => date(DATE_ATOM),
            ]);
        }
    }
}
