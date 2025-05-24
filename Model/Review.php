<?php
class Review
{
    public static function create(PDO $pdo, int $reviewerId, int $reviewedId, int $rating, string $comment): bool
    {
        $stmt = $pdo->prepare("
            INSERT INTO reviews (reviewer_id, reviewed_id, rating, comment)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$reviewerId, $reviewedId, $rating, $comment]);
    }

    public static function autoBanUsers(PDO $pdo): void
    {
        $pdo->exec("
            UPDATE users
            SET banned = TRUE
            WHERE id IN (
                SELECT reviewed_id
                FROM reviews
                GROUP BY reviewed_id
                HAVING AVG(rating) < 3
            )
        ");
    }
}
