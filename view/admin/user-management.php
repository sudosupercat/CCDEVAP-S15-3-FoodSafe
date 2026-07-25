<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../../styles/css/global.css">
    <link rel="stylesheet" href="../../styles/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="../../styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../styles/css/admin/user-management.css">
    <link rel="icon" type="image/x-icon" href="../../src/images/logo-tab.png">
    <script src="../../styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <script src="../../styles/js/nav-bar.js"></script>
    <script src="../../styles/js/jquery-3.7.1.min.js"></script>
    <script src="../../styles/js/dataTables.min.js"></script>
    <script src="../../styles/js/admin/users.js"></script>
</head>
<body>
    <?php include __DIR__ . '/../navbar.php';?>

    <h1>User Management</h1>
    <div class="container">
        <div class="table-wrapper">
            <button type="button" id="button-add-user">+ Add User</button>
        <table id="user-man-table" class="table table-striped">
            <thead>
            <tr>
                <th colspan="6">Current Users</th>
            </tr>
            <tr>
                <th>User #</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>District</th>
                <th>Actions</th> 
            </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($users as $user) {
                    if ($user['deleteFlag'] == 0) {
                        
                        $statusAction = $user['status'] ? 'Disable' : 'Enable';
                        $statusClass = $user['status'] ? 'btn-disable' : 'btn-enable';

                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['fullName']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['districtName']) . "</td>";
                        echo "<td>";
                        echo "<div class='actions-button'>";
                        echo "
                        <form method='POST' action='../../controller/admin/adminUsers.controller.php'>
                            <input type='hidden' name='action' value='update'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($user['userID']) . "'>
                            <button type='submit' class='{$statusClass}'>{$statusAction}</button>
                        </form>";
                        echo "
                        <form method='GET' action='../../controller/admin/adminUsers.controller.php'>
                            <input type='hidden' name='action' value='edit'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($user['userID']) . "'>
                            <button type='submit' class='btn-edit'>Edit</button>
                        </form>";
                        echo "
                        <form method='POST' action='../../controller/admin/adminUsers.controller.php'>
                            <input type='hidden' name='action' value='delete'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($user['userID']) . "'>
                            <button type='submit' class='btn-delete'>Delete</button>
                        </form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    $i++;
                }
                ?>
            </tbody>
            <tfoot>
            <tr>
                <th>User #</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>District</th>
                <th>Actions</th>  
            </tr>
            </tfoot>
        </table>
    </div>
    </div>

    <div id="toast" class="custom-toast hidden">
        <div class="toast-text">
            <strong id="toast-title">Toast Title</strong>
            <p id="toast-message">Toast Message</p>
        </div>
        <span class="toast-close" onclick="hideToast()">&times;</span>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit User</h2>
            <form id="edit-form" method="POST" action="../../controller/admin/adminUsers.controller.php">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" id="edit-userID" name="userID" value="<?php echo $selectedUser['userID'] ?? '' ?>">

                <label for="edit-email">Email:</label><br>
                <input type="email" id="edit-email" name="email" value="<?php echo $selectedUser['email'] ?? '' ?>" required><br><br>

                <label for="edit-firstName">First Name:</label><br>
                <input type="text" id="edit-firstName" name="firstName" value="<?php echo $selectedUser['firstName'] ?? '' ?>" required><br><br>

                <label for="edit-lastName">Last Name:</label><br>
                <input type="text" id="edit-lastName" name="lastName" value="<?php echo $selectedUser['lastName'] ?? '' ?>" required><br><br>

                <label for="edit-district">District:</label><br>
                <select id="edit-district" name="districtID">
                    <option value="">Select District</option>
                    <?php foreach ($districts as $district): ?>
                        <option value="<?php echo $district['districtID'] ?>"<?php echo ($selectedUser['districtID'] == $district['districtID']) ? 'selected' : '' ?>><?php echo htmlspecialchars($district['name']) ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>

        let addUser = document.getElementById("button-add-user");

        addUser.addEventListener("click", () => {
            window.location.href = '../../controller/admin/adminAddUsers.controller.php';
        });

        let modal = document.getElementById("edit-modal");
        let span = document.getElementsByClassName("close")[0];
        <?php if (isset($selectedUser)): ?>
        document.getElementById("edit-modal").style.display = "block";
        document.body.classList.add("modal-open");
        <?php endif; ?>

        span.onclick = function() {
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                document.body.classList.remove("modal-open");
            }
        }

        let toastTimeout;
        
        <?php
        $toastMessages = [
            "edit" => "User has been edited.",
            "update" => "User status has been updated.",
            "delete" => "User has been deleted."
        ];

        if (isset($_GET['toast']) && isset($toastMessages[$_GET['toast']])):
        ?>

        function showToast(type, title, message) {
            const toast = document.getElementById('toast');

            document.getElementById('toast-title').textContent = title;
            document.getElementById('toast-message').textContent = message;

            toast.classList.remove('success', 'error');
            toast.classList.remove('hidden');
            toast.classList.add(type);

            clearTimeout(toastTimeout);

            toastTimeout = setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove(type);
            }, 5000);
        }

        window.onload = function() {
            showToast(
                "success",
                "Success.",
                "<?php echo $toastMessages[$_GET['toast']] ?>"
            );
        }

        <?php endif; ?>

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('hidden');
            toast.classList.remove('success', 'error');
            clearTimeout(toastTimeout);
        }
    </script>
    <footer class="site-footer">
        FoodSafe - Copyright 2026
    </footer>
</body>
</html>
