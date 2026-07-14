<?php
class RestaurantModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getHomepageData() {
        $data = [
            'latestRestoName' => 'No reviews yet',
            'latestRestoImage' => '../../src/images/default-placeholder.jpg',
            'totalRestaurants' => 0,
            'randomPlaceholder' => 'Search for a restaurant...'
        ];

        try {
            $query1 = "SELECT r.name, r.image 
                       FROM restaurants r
                       JOIN inspections i ON r.restoID = i.restoID
                       ORDER BY i.inspectionDate DESC
                       LIMIT 1";
            $stmt1 = $this->pdo->prepare($query1);
            $stmt1->execute();
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            if ($row1) {
                $data['latestRestoName'] = $row1['name'];
                $data['latestRestoImage'] = $row1['image'];
            }

            $query2 = "SELECT COUNT(*) as total FROM restaurants";
            $stmt2 = $this->pdo->prepare($query2);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($row2) {
                $data['totalRestaurants'] = $row2['total'];
            }

            $query3 = "SELECT name FROM restaurants ORDER BY RAND() LIMIT 1";
            $stmt3 = $this->pdo->prepare($query3);
            $stmt3->execute();
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            if ($row3) {
                $data['randomPlaceholder'] = $row3['name'] . "...";
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        }
        
        return $data;
    }

    public function getSearchResults($query, $sortOrder) {
        $sql = "SELECT r.restoID, r.name, r.image, 
                COUNT(v.violationID) AS violations,
                (SELECT inspectionDate FROM inspections WHERE restoID = r.restoID ORDER BY inspectionDate DESC LIMIT 1) AS date
                FROM restaurants r
                LEFT JOIN inspections i ON r.restoID = i.restoID
                LEFT JOIN violations v ON i.inspectionID = v.inspectionID
                WHERE r.name LIKE :query
                GROUP BY r.restoID";

        if ($sortOrder === 'az') {
            $sql .= " ORDER BY name ASC";
        } elseif ($sortOrder === 'za') {
            $sql .= " ORDER BY name DESC";
        } elseif ($sortOrder === 'violow-hi') {
            $sql .= " ORDER BY violations ASC";
        } elseif ($sortOrder === 'viohi-low') {
            $sql .= " ORDER BY violations DESC";
        }
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['query' => '%' . $query . '%']);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $key => $resto) {
                $violationCount = (int)$resto['violations'];

                if ($violationCount <= 10) {
                    $grade = 'A';
                } elseif ($violationCount <= 25) {
                    $grade = 'B';
                } elseif ($violationCount <= 55) {
                    $grade = 'C';
                } else {
                    $grade = 'F';
                }
                $results[$key]['grade'] = $grade;

                $results[$key]['displayDate'] = $resto['date'] ? date("F d, Y", strtotime($resto['date'])) : 'No inspections yet';
            }

            return $results;
            
        } catch (PDOException $e) {
            error_log("Search Error: " . $e->getMessage());
            return [];
        }
    }
}
?>