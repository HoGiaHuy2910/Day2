<!DOCTYPE html>
<html>
<head>
    <title>Customer Management</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        input, select { padding: 5px; margin: 5px; }
        .form-group { margin-bottom: 10px; }
    </style>
</head>
<body>

<?php
session_start();

class Customer {
    public $id;
    public $username;
    public $password;
    public $fullname;
    public $address;
    public $phone;
    public $gender;
    public $birthday;
    
    public function __construct($id, $username, $password, $fullname, $address, $phone, $gender, $birthday) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->fullname = $fullname;
        $this->address = $address;
        $this->phone = $phone;
        $this->gender = $gender;
        $this->birthday = $birthday;
    }
}

if (!isset($_SESSION['customers'])) {
    $_SESSION['customers'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $deleteIndex = $_POST['delete_index'];
        unset($_SESSION['customers'][$deleteIndex]);
        $_SESSION['customers'] = array_values($_SESSION['customers']); 
        echo "<p style='color: red;'>Customer deleted successfully!</p>";
    } elseif (isset($_POST['id'])) {
        $customer = new Customer(
            $_POST['id'],
            $_POST['username'],
            $_POST['password'],
            $_POST['fullname'],
            $_POST['address'],
            $_POST['phone'],
            $_POST['gender'],
            $_POST['birthday']
        );
        
        $_SESSION['customers'][] = $customer;
        echo "<p style='color: green;'>Customer added successfully!</p>";
    }
}
?>

<h2>Add New Customer</h2>
<form method="POST">
    <div class="form-group">
        <label>ID:</label>
        <input type="text" name="id" required>
    </div>
    
    <div class="form-group">
        <label>Username:</label>
        <input type="text" name="username" required>
    </div>
    
    <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" required>
    </div>
    
    <div class="form-group">
        <label>Full Name:</label>
        <input type="text" name="fullname" required>
    </div>
    
    <div class="form-group">
        <label>Address:</label>
        <input type="text" name="address">
    </div>
    
    <div class="form-group">
        <label>Phone:</label>
        <input type="text" name="phone" required>
    </div>
    
    <div class="form-group">
        <label>Gender:</label>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
<option value="Female">Female</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Birthday:</label>
        <input type="date" name="birthday">
    </div>
    
    <button type="submit">Add Customer</button>
</form>

<h2>Customer List</h2>
<?php if (empty($_SESSION['customers'])): ?>
    <p>No customers found.</p>
<?php else: ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Full Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Birthday</th>
            <th>Action</th>
        </tr>
        <?php foreach ($_SESSION['customers'] as $index => $customer): ?>
        <tr>
            <td><?php echo $customer->id; ?></td>
            <td><?php echo $customer->username; ?></td>
            <td><?php echo $customer->password; ?></td>
            <td><?php echo $customer->fullname; ?></td>
            <td><?php echo $customer->address; ?></td>
            <td><?php echo $customer->phone; ?></td>
            <td><?php echo $customer->gender; ?></td>
            <td><?php echo $customer->birthday; ?></td>
            <td>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="delete_index" value="<?php echo $index; ?>">
                    <button type="submit" style="background: red; color: white; padding: 5px 10px; border: none; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</body>
</html>