<?php
class RestaurantModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getHomepageData() {
        $data = [
            'latestRestoID' => '',
            'latestRestoName' => 'No inspections yet',
            'latestRestoImage' => '../../src/images/default-placeholder.jpg',
            'totalRestaurants' => 0,
            'randomPlaceholder' => 'Search for a restaurant...'
        ];

        try {
            $query1 = "SELECT r.restoID, r.name, r.image 
                       FROM restaurants r
                       JOIN inspections i ON r.restoID = i.restoID
                       ORDER BY i.inspectionDate DESC
                       LIMIT 1";
            $stmt1 = $this->pdo->prepare($query1);
            $stmt1->execute();
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            if ($row1) {
                $data['latestRestoID'] = $row1['restoID'];
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
        // Per-inspection severity -> grade points, averaged per restaurant.
        // Matches the grading used on the restaurant detail page.
        $sql = "SELECT r.restoID, r.name, r.image,
                       COALESCE(t.violations, 0) AS violations,
                       t.avgPoints AS avgPoints,
                       (SELECT inspectionDate FROM inspections
                         WHERE restoID = r.restoID
                         ORDER BY inspectionDate DESC LIMIT 1) AS date
                FROM restaurants r
                LEFT JOIN (
                    SELECT s.restoID,
                           SUM(s.vc) AS violations,
                           AVG(s.points) AS avgPoints
                    FROM (
                        SELECT i.restoID,
                               i.inspectionID,
                               COUNT(v.violationID) AS vc,
                               CASE
                                 WHEN COALESCE(SUM(CAST(req.severityLvl AS UNSIGNED)), 0) = 0  THEN 5
                                 WHEN COALESCE(SUM(CAST(req.severityLvl AS UNSIGNED)), 0) <= 5 THEN 4
                                 WHEN COALESCE(SUM(CAST(req.severityLvl AS UNSIGNED)), 0) <= 10 THEN 3
                                 ELSE 1
                               END AS points
                        FROM inspections i
                        LEFT JOIN violations v ON v.inspectionID = i.inspectionID
                        LEFT JOIN requirements req ON req.requirementCode = v.requirementCode
                        GROUP BY i.inspectionID, i.restoID
                    ) s
                    GROUP BY s.restoID
                ) t ON t.restoID = r.restoID
                WHERE r.name LIKE :query";

        if ($sortOrder === 'az') {
            $sql .= " ORDER BY r.name ASC";
        } elseif ($sortOrder === 'za') {
            $sql .= " ORDER BY r.name DESC";
        } elseif ($sortOrder === 'violow-hi') {
            $sql .= " ORDER BY violations ASC";
        } elseif ($sortOrder === 'viohi-low') {
            $sql .= " ORDER BY violations DESC";
        } elseif ($sortOrder === 'gradebest') {
            // Best grade first (A -> F); restaurants with no inspections go last
            $sql .= " ORDER BY (t.avgPoints IS NULL) ASC, t.avgPoints DESC, r.name ASC";
        } elseif ($sortOrder === 'gradeworst') {
            // Worst grade first (F -> A); restaurants with no inspections go last
            $sql .= " ORDER BY (t.avgPoints IS NULL) ASC, t.avgPoints ASC, r.name ASC";
        } else {
            $sql .= " ORDER BY r.name ASC";
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['query' => '%' . $query . '%']);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $key => $resto) {
                if ($resto['avgPoints'] === null) {
                    $results[$key]['rating'] = null;
                    $results[$key]['grade']  = null;
                } else {
                    $rating = round((float)$resto['avgPoints'], 1);
                    $results[$key]['rating'] = $rating;

                    if ($rating >= 4.5)      $results[$key]['grade'] = 'A';
                    elseif ($rating >= 3.5)  $results[$key]['grade'] = 'B';
                    elseif ($rating >= 2.5)  $results[$key]['grade'] = 'C';
                    else                     $results[$key]['grade'] = 'F';
                }

                $results[$key]['displayDate'] = $resto['date']
                    ? date("F d, Y", strtotime($resto['date']))
                    : 'No inspections yet';
            }

            return $results;

        } catch (PDOException $e) {
            error_log("Search Error: " . $e->getMessage());
            return [];
        }
    }

    public function getRestaurantById($restoID) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM restaurants WHERE restoID = ?");
            $stmt->execute([$restoID]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Restaurant Error: " . $e->getMessage());
            return null;
        }
    }

    public function getAllRestaurants() {
        try {
            $stmt = $this->pdo->query("SELECT restoID, name FROM restaurants ORDER BY name ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get All Restaurants Error: " . $e->getMessage());
            return [];
        }
    }
}
?>
