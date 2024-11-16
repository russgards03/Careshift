<?php
include '../config/config.php';
include '../class/class.admin.php';
include '../class/class.logs.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
	case 'new':
        create_new_admin($con);
	break;
    case 'update':
        update_admin();
	break;
    case 'delete':
        delete_admin();
    break;
}

function create_new_admin($con){
    $admin = new Admin();
    $log = new Log();

    $username = $_POST['username'];
    $first_name = ucfirst($_POST['first_name']);
    $middle_name = ucfirst($_POST['middle_name']);
    $last_name = ucfirst($_POST['last_name']);
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $department = $_POST['department'];
    $access = $_POST['access'];
    $password = 123;

    $result = $admin->new_admin($username,$password,$first_name,$middle_name,$last_name,$email,$contact_no,$access,$department);

    if ($result) {
        $id = $admin->get_last_inserted_admin_id();;

        $log_action = "Created New Admin";
        $log_description = "Created a new admin account for $first_name $last_name";
        $adm_id = $_SESSION['adm_id']; 

        $log->addLog($log_action, $log_description, $adm_id, $id);

        header("location: ../index.php?page=admins");
    } else {
        echo "<script>alert('Error creating new admin.'); window.history.back();</script>";
    }
}

function update_admin(){  
    $admin = new Admin();
    $log = new Log();

    $id = $_POST['id'];
    $username = $_POST['username'];
    $first_name = ucfirst($_POST['first_name']);
    $middle_name = ucfirst($_POST['middle_name']);
    $last_name = ucfirst($_POST['last_name']);
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $access = $_POST['access'];

    $result = $admin->update_admin($id,$username,$first_name,$middle_name,$last_name,$email,$contact_no,$access);

    if($result){

        $admin_info = $admin->get_admin_by_id($id);
        $log_action = "Update Admin";
        $log_description = "Updated admin account for $first_name $last_name (Username: $username)";
        $adm_id = $_SESSION['adm_id']; 

        $log->addLog($log_action, $log_description, $adm_id, $id);
        header('location: ../index.php?page=admins&subpage=profile&id=' . $id);
    } else {
        echo "<script>alert('Error updating admin.'); window.history.back();</script>";
    }
}

function delete_admin()
{
    if (isset($_POST['id'])) {
        $admin = new Admin();
        $log = new Log();

        $id = $_POST['id'];

        $admin_info = $admin->get_admin_by_id($id);
        $first_name = $admin_info['adm_fname'];
        $last_name = $admin_info['adm_lname'];
        $username = $admin_info['adm_username'];

        $result = $admin->delete_admin($id);

        if ($result) {
            $log_action = "Delete Admin";
            $log_description = "Deleted admin account for $first_name $last_name";
            $adm_id = $_SESSION['adm_id'];

            $log->addLog($log_action, $log_description, $adm_id, $id);

            header("location: ../index.php?page=admins&subpage=records");
        } else {
            echo "Error deleting admin.";
        }
    } else {
        echo "Invalid Admin ID.";
    }
}
?>