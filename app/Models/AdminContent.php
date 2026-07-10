<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

final class AdminContent
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function listTaps(): array
    {
        return $this->pdo->query('SELECT * FROM taps ORDER BY is_on_tap DESC, updated_at DESC, id DESC')->fetchAll() ?: [];
    }

    public function createTap(array $payload): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO taps (name, style, abv, price_store_liter, price_bar_half, image_path, is_on_tap, created_at, updated_at)
            VALUES (:name, :style, :abv, :price_store_liter, :price_bar_half, :image_path, :is_on_tap, :created_at, :updated_at)'
        );

        $statement->execute($payload);
    }

    public function updateTap(int $id, array $payload): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE taps
            SET name = :name,
                style = :style,
                abv = :abv,
                price_store_liter = :price_store_liter,
                price_bar_half = :price_bar_half,
                image_path = :image_path,
                updated_at = :updated_at
            WHERE id = :id'
        );

        $statement->execute([
            ':id' => $id,
            ...$payload,
        ]);
    }

    public function toggleTap(int $id, bool $enabled): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE taps SET is_on_tap = :is_on_tap, updated_at = :updated_at WHERE id = :id'
        );

        $statement->execute([
            ':id' => $id,
            ':is_on_tap' => $enabled ? 1 : 0,
            ':updated_at' => date(DATE_ATOM),
        ]);
    }

    public function deleteTap(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM taps WHERE id = :id');
        $statement->execute([':id' => $id]);
    }

    public function listEvents(): array
    {
        return $this->pdo->query('SELECT * FROM events ORDER BY event_at DESC, id DESC')->fetchAll() ?: [];
    }

    public function createEvent(array $payload): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO events (title, announce, description, cover_image_path, event_at, created_at, updated_at)
            VALUES (:title, :announce, :description, :cover_image_path, :event_at, :created_at, :updated_at)'
        );

        $statement->execute($payload);
    }

    public function updateEvent(int $id, array $payload): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE events
            SET title = :title,
                announce = :announce,
                description = :description,
                cover_image_path = :cover_image_path,
                event_at = :event_at,
                updated_at = :updated_at
            WHERE id = :id'
        );

        $statement->execute([
            ':id' => $id,
            ...$payload,
        ]);
    }

    public function deleteEvent(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM events WHERE id = :id');
        $statement->execute([':id' => $id]);
    }

    public function listPromotions(): array
    {
        return $this->pdo->query('SELECT * FROM promotions ORDER BY updated_at DESC, id DESC')->fetchAll() ?: [];
    }

    public function createPromotion(array $payload): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO promotions (title, announce, description, cover_image_path, created_at, updated_at)
            VALUES (:title, :announce, :description, :cover_image_path, :created_at, :updated_at)'
        );

        $statement->execute($payload);
    }

    public function updatePromotion(int $id, array $payload): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE promotions
            SET title = :title,
                announce = :announce,
                description = :description,
                cover_image_path = :cover_image_path,
                updated_at = :updated_at
            WHERE id = :id'
        );

        $statement->execute([
            ':id' => $id,
            ...$payload,
        ]);
    }

    public function deletePromotion(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM promotions WHERE id = :id');
        $statement->execute([':id' => $id]);
    }

    public function listNews(): array
    {
        return $this->pdo->query('SELECT * FROM news ORDER BY updated_at DESC, id DESC')->fetchAll() ?: [];
    }

    public function createNews(array $payload): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO news (title, content, cover_image_path, created_at, updated_at)
            VALUES (:title, :content, :cover_image_path, :created_at, :updated_at)'
        );

        $statement->execute($payload);
    }

    public function updateNews(int $id, array $payload): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE news
            SET title = :title,
                content = :content,
                cover_image_path = :cover_image_path,
                updated_at = :updated_at
            WHERE id = :id'
        );

        $statement->execute([
            ':id' => $id,
            ...$payload,
        ]);
    }

    public function deleteNews(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM news WHERE id = :id');
        $statement->execute([':id' => $id]);
    }

    public function listMediaAssets(): array
    {
        return $this->pdo->query('SELECT * FROM media_assets ORDER BY created_at DESC, id DESC')->fetchAll() ?: [];
    }

    public function createMediaAsset(array $payload): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO media_assets (file_name, original_name, relative_path, mime_type, size_bytes, created_at)
            VALUES (:file_name, :original_name, :relative_path, :mime_type, :size_bytes, :created_at)'
        );

        $statement->execute($payload);
    }
}
