<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/bootstrap-5.3.8-dist/css/bootstrap.css">
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/css/global.css">
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/css/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/CCDEVAP-S15-3-FoodSafe/styles/css/admin/user-management.css">
    <script src="/CCDEVAP-S15-3-FoodSafe/styles/bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <script src="/CCDEVAP-S15-3-FoodSafe/styles/js/nav-bar.js"></script>
    <script src="/CCDEVAP-S15-3-FoodSafe/styles/js/jquery-3.7.1.min.js"></script>
    <script src="/CCDEVAP-S15-3-FoodSafe/tyles/js/dataTables.min.js"></script>
    <script src="/CCDEVAP-S15-3-FoodSafe/styles/js/admin/users.js"></script>
</head>
<body>
    <div id="navBar"></div>

    <h1>User Management</h1>

    <div class="container"> 
        <table id="user-man-table" class="table table-striped">
            <thead>
            <tr>
                <th colspan="8">Current Users</th>
            </tr>
            <tr>
                <th>User ID</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>District</th>
                <th>Status</th>
                <th colspan="3">Actions</th> 
            </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user) {
                    if ($user['deleteFlag'] == 0) {
                        $statusLabel = $user['status'] ? 'Active' : 'Inactive';
                        $statusAction = $user['status'] ? 'Disable' : 'Enable';
                        $statusClass = $user['status'] ? 'btn-disable' : 'btn-enable';

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($user['userID']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['firstName']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['lastName']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['districtName']) . "</td>";
                        echo "<td>" . htmlspecialchars($statusLabel) . "</td>";
                        echo "<td>";
                        echo "<div class='actions-button'>";
                        #TO EDIT!!!!!!
                        echo "<button type='button' class='btn-edit' </button>";
                        echo "
                        <form method='POST' action='/CCDEVAP-S15-3-FoodSafe/controller/admin-users.php'>
                            <input type='hidden' name='action' value='update'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($user['userID']) . "'>
                            <button type='submit' class='{$statusClass}'>{$statusAction}</button>
                        </form>";
                        echo "
                        <form method='POST' action='/CCDEVAP-S15-3-FoodSafe/controller/admin-users.php'>
                            <input type='hidden' name='action' value='delete'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($user['userID']) . "'>
                            <button type='submit' class='btn-delete'>Delete</button>
                        </form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
            <tfoot>
            <tr>
                <th>User ID</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>District</th>
                <th>Status</th>
                <th colspan="3">Actions</th>  
            </tr>
            </tfoot>
        </table>
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
            <h2>Edit Form</h2>
                <form id="edit-form">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" required><br><br>
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" required><br><br>
                    <label for="district">District:</label>
                    <select id="district" name="district">
                        <option value="">Select District</option>
                        <?php
                            foreach($districts as $district) {
                                echo "<option value='" . $district['districtID'] . "'>" . htmlspecialchars($district['name']) . "</option>";
                            }
                        ?>
                    </select><br><br>
                    <button type="submit">Save Changes</button>
                </form>
        </div>
    </div>

    <footer class="site-footer">
        FoodSafe - Copyright 2026
    </footer>

    <script>

    function showToast(type, title, message) {
        const toast = document.getElementById('toast');
        document.getElementById('toast-title').textContent = title;
        document.getElementById('toast-message').textContent = message;
        
        toast.classList.remove('success', 'error');
        toast.classList.remove('hidden');
        toast.classList.add(type);
        
        setTimeout(() => {
            toast.classList.add('hidden')
            toast.classList.remove(type);
        }, 3000);
    }

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('hidden');
            toast.classList.remove('pending', 'reviewed', 'dismissed');
            clearTimeout(toastTimeout);
        }
</script>
</body>
</html>
