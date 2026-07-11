<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchIndexerService
{
    public function generateKeywords(array $strings, string $extraKeywords = null): string
    {
        $combined = implode(' ', $strings) . ' ' . $extraKeywords;
        $cleaned = preg_replace('/\s+/', ' ', $combined);
        return strtolower(trim($cleaned));
    }

    public function updateProductKeywords($productId, string $keywords): void
    {
        DB::statement("
            UPDATE products
            SET search_keywords = ?
            WHERE id = ?
        ", [$keywords, $productId]);
    }

    public function updateBlogKeywords($blogId, string $keywords): void
    {
        DB::statement("
            UPDATE blogs
            SET search_keywords = ?
            WHERE id = ?
        ", [$keywords, $blogId]);
    }

    public function insertProduct(array $data): bool
    {
        $slug = $data['slug'] ?? Str::slug($data['title']);

        $searchKeywords = $this->generateKeywords(
            [$data['title'], $data['short_description'] ?? ''],
            $data['extra_keywords'] ?? 'product'
        );

        // ⚡ মেটা ডেটা সহ সব কলাম এখানে যুক্ত করা হলো
        return DB::insert("
            INSERT INTO products (
                title, short_description, slug, featured_image, regular_price, sale_price,
                meta_title, meta_description, meta_keywords, canonical_url,
                search_keywords, created_at, updated_at
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ", [
            $data['title'],
            $data['short_description'] ?? null,
            $slug,
            $data['featured_image'] ?? null,
            $data['regular_price'] ?? 0,
            $data['sale_price'] ?? null,
            $data['meta_title'] ?? null,
            $data['meta_description'] ?? null,
            $data['meta_keywords'] ?? null,
            $data['canonical_url'] ?? null,
            $searchKeywords
        ]);
    }

    public function insertBlog(array $data): bool
    {
        $slug = $data['slug'] ?? Str::slug($data['title']);

        $searchKeywords = $this->generateKeywords(
            [$data['title'], $data['description'] ?? '', $data['affiliate_source'] ?? ''],
            $data['extra_keywords'] ?? 'blog'
        );

        // ⚡ মেটা ডেটা সহ সব কলাম এখানে যুক্ত করা হলো
        return DB::insert("
            INSERT INTO blogs (
                title, description, slug, thumbnail, affiliate_source,
                meta_title, meta_description, meta_keywords, canonical_url,
                search_keywords, created_at, updated_at
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ", [
            $data['title'],
            $data['description'] ?? null,
            $slug,
            $data['thumbnail'] ?? null,
            $data['affiliate_source'] ?? null,
            $data['meta_title'] ?? null,
            $data['meta_description'] ?? null,
            $data['meta_keywords'] ?? null,
            $data['canonical_url'] ?? null,
            $searchKeywords
        ]);
    }
}
