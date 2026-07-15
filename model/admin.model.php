<?php
require __DIR__ . '/../config/db.php';

// DASHBOARD
function getInspectorCounts($pdo, $year, $month) {
    $result = new stdClass();

    $monthFilter = "";
    $params = [$year];

    # If no month is selected, display year result
    if ($month != '') {
        $monthFilter = " AND MONTH(createdAt) = ?";
        $params[] = $month + 1;
    }

    # Get total number for created users
    $sql_created = $pdo->prepare("SELECT COUNT(*) AS created 
                            FROM users
                            WHERE role='Inspector'
                            AND YEAR(createdAt) = ?
                            $monthFilter");
    $sql_created->execute($params);
    $created_results = $sql_created->fetch(PDO::FETCH_ASSOC);

    # Get total number of disabled users
    $sql_disabled = $pdo->prepare("SELECT COUNT(*) AS disabled 
                                FROM users
                                WHERE role='Inspector' 
                                AND status='0'
                                AND YEAR(createdAt) = ?
                                $monthFilter");
    $sql_disabled->execute($params);
    $disabled_results = $sql_disabled->fetch(PDO::FETCH_ASSOC);

    # Get total number of deleted users
    $sql_deleted = $pdo->prepare("SELECT COUNT(*) AS deleted
                                FROM users
                                WHERE role='Inspector' 
                                AND deleteFlag = '1'
                                AND YEAR(createdAt) = ?
                                $monthFilter");
    $sql_deleted->execute($params);
    $deleted_results = $sql_deleted->fetch(PDO::FETCH_ASSOC);

    $result->created = $created_results['created'];
    $result->disabled = $disabled_results['disabled'];
    $result->deleted = $deleted_results['deleted'];

    return $result;
}

// DASHBOARD -- Charts
function getPassInspection($pdo, $year) {
    $sql = $pdo->prepare("SELECT COUNT(*) as total, MONTH(inspectionDate) as month
                        FROM inspections
                        WHERE YEAR(inspectionDate) = ?
                        AND grade = 'Pass'
                        GROUP BY MONTH(inspectionDate);");
    $sql->execute([$year]);

    $passed_data = [];
    while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        array_push($passed_data , $row);
    }

    return json_encode($passed_data);
}

function getFailInspection($pdo, $year) {
    $sql = $pdo->prepare("SELECT COUNT(*) as total, MONTH(inspectionDate) as month
                        FROM inspections
                        WHERE YEAR(inspectionDate) = ?
                        AND grade = 'Fail'
                        GROUP BY MONTH(inspectionDate);");
    $sql->execute([$year]);

    $failed_data = [];
    while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        array_push($failed_data , $row);
    }

    return json_encode($failed_data);
}

function getViolationCount($pdo, $year) {
    $sql = $pdo->prepare("SELECT COUNT(*) as total, v.requirementCode as num, rq.title as name
                        FROM violations v 
                        LEFT JOIN requirements rq ON v.requirementCode = rq.requirementCode
                        LEFT JOIN inspections i ON v.inspectionID = i.inspectionID
                        WHERE YEAR(i.inspectionDate) = ?
                        GROUP BY v.requirementCode;");
    $sql->execute([$year]);
    $violation_data = [];
    while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        array_push($violation_data, $row);
    }

    return json_encode($violation_data);
}

// USER MANAGEMENT
function getUsers($pdo) {
    $sql = $pdo->query("SELECT u.userID, u.email, u.firstName, u.lastName, u.role, u.districtID, d.name as districtName, u.status, u.deleteFlag
                        FROM users u
                        LEFT JOIN districts d 
                        ON u.districtID = d.districtID;");
    $users = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}

function getDistricts($pdo) {
    $sql = $pdo->query("SELECT districtID, name FROM districts;");
    $districts = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $districts;
}

function getUserByID($pdo, $userID) {
    $sql = $pdo->prepare("SELECT u.userID, u.email, u.firstName, u.lastName, u.role, u.districtID, d.name as districtName, u.status, u.deleteFlag
                        FROM users u
                        LEFT JOIN districts d 
                        ON u.districtID = d.districtID
                        WHERE u.userID = ?;");
    $sql->execute([$userID]);
    return $sql->fetch(PDO::FETCH_ASSOC);
}

function editUser($pdo, $userID, $email, $firstName, $lastName, $districtID) {
    $sql = $pdo->prepare("UPDATE users
                        SET email = ?, firstName = ?, lastName = ?, districtID = ?
                        WHERE userID = ?;");
    $sql_new = $sql->execute([$email, $firstName, $lastName, $districtID, $userID]);

    return $sql_new;
}

function updateStatus($pdo, $userID) {
    $sql_curr = $pdo->prepare("SELECT status
                        FROM users
                        WHERE userID = ?;");
    $sql_curr->execute([$userID]);
    $user = $sql_curr->fetch(PDO::FETCH_ASSOC);

    if ($user['status'] == 1) {
        $editStatus = 0;
    } else {
        $editStatus = 1;
    }

    $sql_new = $pdo->prepare("UPDATE users
                            SET status = ?
                            WHERE userID = ?;");

    $result = $sql_new->execute([$editStatus, $userID]);

    return $result;
}

function checkEmailExists($pdo, $email) {
    $sql = $pdo->prepare("SELECT userID FROM users WHERE email = ?");
    $sql->execute([$email]);
    return $sql->rowCount() > 0;
}

function registerNewUser($pdo, $email, $password, $role, $firstName, $lastName, $districtID) {
    try {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // NOTE: 'users' table has no 'username' column, so it's intentionally excluded.
        // loginAttempt is NOT NULL with no default, so it must be supplied explicitly.
        $sql = $pdo->prepare("INSERT INTO users (email, password, firstName, lastName, districtID, role, loginAttempt, status, deleteFlag) 
                             VALUES (?, ?, ?, ?, ?, ?, 0, 1, 0)");
        
        return $sql->execute([$email, $hashed_password, $firstName, $lastName, $districtID, $role]);
    } catch (PDOException $e) {
        error_log("Registration Error: " . $e->getMessage());
        return false;
    }
}

function deleteUser($pdo, $userID) {
    $sql = $pdo->prepare("UPDATE users
                        SET deleteFlag = 1
                        WHERE userID = ?;");
    $result = $sql->execute([$userID]);

    return $result;
}

?>
