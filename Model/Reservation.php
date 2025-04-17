<?php
class Reservation
{
    private $trip_id;
    private $user_id;
    private $seats_reserved;

    public function __construct($trip_id, $user_id, $seats_reserved)
    {
        $this->trip_id = $trip_id;
        $this->user_id = $user_id;
        $this->seats_reserved = $seats_reserved;
    }

    // Réserver un voyage
    public static function createReservation($pdo, $reservation)
    {
        $stmt = $pdo->prepare('INSERT INTO reservations (trip_id, user_id, seats_reserved) VALUES (?, ?, ?)');
        return $stmt->execute([$reservation->trip_id, $reservation->user_id, $reservation->seats_reserved]);
    }

    // Annuler une réservation
    public static function cancelReservation($pdo, $reservationId, $userId)
    {
        $stmt = $pdo->prepare('DELETE FROM reservations WHERE id = :reservation_id AND user_id = :user_id');
        $stmt->bindParam(':reservation_id', $reservationId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
