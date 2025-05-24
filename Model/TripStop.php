<?php
class TripStop
{
    public static function create(PDO $pdo, int $tripId, string $location, string $stopTime): bool
    {
        $stmt = $pdo->prepare("INSERT INTO trip_stops (trip_id, location, stop_time) VALUES (?, ?, ?)");
        return $stmt->execute([$tripId, $location, $stopTime]);
    }

    public static function getByTripId(PDO $pdo, int $tripId): array
    {
        $stmt = $pdo->prepare("SELECT * FROM trip_stops WHERE trip_id = ? ORDER BY stop_time");
        $stmt->execute([$tripId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
