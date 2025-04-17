<?php
class Trip
{
    private $departure;
    private $arrival;
    private $date;
    private $time;
    private $seats;
    private $price;
    private $driver_id;

    public function __construct($departure, $arrival, $date, $time, $seats, $price, $driver_id)
    {
        $this->departure = $departure;
        $this->arrival = $arrival;
        $this->date = $date;
        $this->time = $time;
        $this->seats = $seats;
        $this->price = $price;
        $this->driver_id = $driver_id;
    }

    // Créer un nouveau trajet
    public static function create($pdo, $trip)
    {
        $stmt = $pdo->prepare('INSERT INTO trips (departure, arrival, date, time, seats, price, driver_id) VALUES (?, ?, ?, ?, ?, ?, ?)');
        return $stmt->execute([
            $trip->departure,
            $trip->arrival,
            $trip->date,
            $trip->time,
            $trip->seats,
            $trip->price,
            $trip->driver_id
        ]);
    }

    // Récupérer les trajets créés par l'utilisateur
    public static function getTripsByUser($pdo, $userId)
    {
        $stmt = $pdo->prepare('SELECT * FROM trips WHERE driver_id = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les trajets réservés par l'utilisateur
    public static function getReservedTripsByUser($pdo, $userId)
    {
        $stmt = $pdo->prepare('SELECT t.*, r.seats_reserved, r.id AS reservation_id 
                               FROM trips t
                               INNER JOIN reservations r ON t.id = r.trip_id
                               WHERE r.user_id = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer un trajet créé par l'utilisateur
    public static function deleteTrip($pdo, $tripId, $userId)
    {
        $stmt = $pdo->prepare('DELETE FROM trips WHERE id = :trip_id AND driver_id = :user_id');
        $stmt->bindParam(':trip_id', $tripId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Annuler une réservation
    public static function cancelReservation($pdo, $reservationId, $userId)
    {
        $stmt = $pdo->prepare('DELETE FROM reservations WHERE id = :reservation_id AND user_id = :user_id');
        $stmt->bindParam(':reservation_id', $reservationId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Récupérer les détails d'un trajet
    public static function getTripById($pdo, $tripId)
    {
        $stmt = $pdo->prepare('SELECT * FROM trips WHERE id = :trip_id');
        $stmt->bindParam(':trip_id', $tripId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Rechercher des trajets
    public static function searchTrips($pdo, $departure, $arrival, $date)
    {
        if (empty($date)) {
            $stmt = $pdo->prepare('SELECT * FROM trips WHERE departure LIKE ? AND arrival LIKE ?');
            $stmt->execute(['%' . $departure . '%', '%' . $arrival . '%']);
        } else {
            $stmt = $pdo->prepare('SELECT * FROM trips WHERE departure LIKE ? AND arrival LIKE ? AND date = ?');
            $stmt->execute(['%' . $departure . '%', '%' . $arrival . '%', $date]);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Réserver un trajet
    public static function reserveTrip($pdo, $tripId, $userId, $seatsReserved)
    {
        $stmt = $pdo->prepare('SELECT driver_id FROM trips WHERE id = ?');
        $stmt->execute([$tripId]);
        $trip = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($trip && $trip['driver_id'] == $userId) {
            throw new Exception("Vous ne pouvez pas réserver votre propre trajet.");
        }

        $stmt = $pdo->prepare('INSERT INTO reservations (trip_id, user_id, seats_reserved) VALUES (?, ?, ?)');
        return $stmt->execute([$tripId, $userId, $seatsReserved]);
    }

}
