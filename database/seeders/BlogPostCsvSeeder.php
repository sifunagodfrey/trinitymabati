<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BlogPostCsvSeeder extends Seeder
{
    // ---------------
    // Lookup caches (avoid re-querying for repeated authors/categories/tags/slugs)
    // ---------------
    private array $authorCache = [];
    private array $categoryCache = [];
    private array $tagCache = [];
    private array $usedPostSlugs = [];

    public function run(): void
    {
        $path = database_path('seeders/data/blog-posts-export.csv');

        if (! file_exists($path)) {
            $this->command->error("CSV file not found at: {$path}");
            return;
        }

        $rows = $this->readCsv($path);
        $imported = 0;

        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                if (trim($row['Post Type'] ?? '') !== 'post') {
                    continue;
                }

                $this->createPost($row);
                $imported++;
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        $this->command->info("Blog post CSV seeding complete: {$imported} posts seeded.");
    }

    // ---------------
    // Insert a su_blog_posts row from one CSV row, plus its category,
    // tags, and author. Only columns that exist on su_blog_posts are populated.
    // ---------------
    private function createPost(array $row): int
    {
        $authorId = $this->findOrCreateAuthor($row);

        $categoryNames = $this->splitList($row['Categories'] ?? '');
        $primaryCategoryId = $categoryNames ? $this->findOrCreateCategory($categoryNames[0]) : null;

        $images = $this->splitList($row['Image URL'] ?? '');

        $slug = $this->uniquePostSlug($this->nullIfBlank($row['Slug'] ?? null) ?? Str::slug($row['Title'] ?? ''));

        $publishedAt = strtolower(trim($row['Status'] ?? '')) === 'publish'
            ? $this->parseDate($row['Date'] ?? null)
            : null;

        $postId = DB::table('su_blog_posts')->insertGetId([
            'author_id' => $authorId,
            'title' => trim($row['Title'] ?? ''),
            'slug' => $slug,
            'content' => $row['Content'] ?? '',
            'excerpt' => $this->nullIfBlank($row['Excerpt'] ?? null),
            'category_id' => $primaryCategoryId,
            'thumbnail' => $images[0] ?? null,
            'banner' => $images[1] ?? null,
            'is_published' => strtolower(trim($row['Status'] ?? '')) === 'publish',
            'published_at' => $publishedAt,
            'created_at' => $this->parseDate($row['Date'] ?? null),
            'updated_at' => $this->parseDate($row['Post Modified Date'] ?? null) ?? $this->parseDate($row['Date'] ?? null),
        ]);

        // ---------------
        // su_post_tag pivot: attach every tag (CSV uses "|" as the list separator)
        // ---------------
        foreach ($this->splitList($row['Tags'] ?? '') as $tagName) {
            DB::table('su_post_tag')->insertOrIgnore([
                'post_id' => $postId,
                'tag_id' => $this->findOrCreateTag($tagName),
            ]);
        }

        return $postId;
    }

    // ---------------
    // Author find-or-create, matched by email since su_users has no
    // username column; a placeholder password is generated for imported
    // authors who don't already have an account.
    // ---------------
    private function findOrCreateAuthor(array $row): int
    {
        $email = trim($row['Author Email'] ?? '');

        if ($email === '') {
            throw new \RuntimeException("Post \"{$row['Title']}\" has no Author Email, cannot resolve author_id.");
        }

        if (isset($this->authorCache[$email])) {
            return $this->authorCache[$email];
        }

        $existing = DB::table('su_users')->where('email', $email)->first();

        if ($existing) {
            return $this->authorCache[$email] = $existing->id;
        }

        return $this->authorCache[$email] = DB::table('su_users')->insertGetId([
            'first_name' => $this->nullIfBlank($row['Author First Name'] ?? null) ?? 'Blog',
            'last_name' => $this->nullIfBlank($row['Author Last Name'] ?? null),
            'email' => $email,
            'password' => Hash::make(Str::random(32)),
        ]);
    }

    // ---------------
    // Category / tag find-or-create helpers
    // ---------------
    private function findOrCreateCategory(string $name): int
    {
        $slug = Str::slug($name);

        if (isset($this->categoryCache[$slug])) {
            return $this->categoryCache[$slug];
        }

        $existing = DB::table('su_blog_categories')->where('slug', $slug)->first();

        if ($existing) {
            return $this->categoryCache[$slug] = $existing->id;
        }

        return $this->categoryCache[$slug] = DB::table('su_blog_categories')->insertGetId([
            'name' => $name,
            'slug' => $slug,
        ]);
    }

    private function findOrCreateTag(string $name): int
    {
        $slug = Str::slug($name);

        if (isset($this->tagCache[$slug])) {
            return $this->tagCache[$slug];
        }

        $existing = DB::table('su_blog_tags')->where('slug', $slug)->first();

        if ($existing) {
            return $this->tagCache[$slug] = $existing->id;
        }

        return $this->tagCache[$slug] = DB::table('su_blog_tags')->insertGetId([
            'name' => $name,
            'slug' => $slug,
        ]);
    }

    // ---------------
    // Slug uniqueness for su_blog_posts.slug (has a UNIQUE constraint)
    // ---------------
    private function uniquePostSlug(string $slug): string
    {
        $base = $slug ?: 'post';
        $slug = $base;
        $suffix = 1;

        while (
            isset($this->usedPostSlugs[$slug])
            || DB::table('su_blog_posts')->where('slug', $slug)->exists()
        ) {
            $slug = $base . '-' . (++$suffix);
        }

        $this->usedPostSlugs[$slug] = true;

        return $slug;
    }

    // ---------------
    // Small parsing helpers
    // ---------------
    private function splitList(?string $value): array
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode('|', $value)), fn ($v) => $v !== ''));
    }

    private function parseDate(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        return trim($value);
    }

    private function nullIfBlank(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        return trim($value);
    }

    // ---------------
    // Minimal CSV reader (handles the UTF-8 BOM this export ships with)
    // ---------------
    private function readCsv(string $path): array
    {
        $handle = fopen($path, 'r');

        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle);
        $rows = [];

        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) < count($header)) {
                $data = array_pad($data, count($header), null);
            } elseif (count($data) > count($header)) {
                $data = array_slice($data, 0, count($header));
            }

            $rows[] = array_combine($header, $data);
        }

        fclose($handle);

        return $rows;
    }
}
