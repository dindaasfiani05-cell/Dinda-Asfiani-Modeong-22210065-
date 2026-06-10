<?php
@$page = $_GET['q'];
if (!empty($page)) {
    switch ($page) {

        case 'dashboard':
            include './pages/dashboard/dashboard.php';
            break;

        case 'upload':
            include './pages/upload/upload.php';
            break;

        case 'up_file':
            include './pages/upload/up_file/up_file.php';
            break;

        case 'delete_file':
            include './pages/upload/delete_file/delete_file.php';
            break;

        case 'run_rule_based':
            include './pages/upload/run_rule_based/run_rule_based.php';
            break;

        case 'pengaturan':
            include './pages/pengaturan/pengaturan.php';
            break;

        case 'edit':
            include './pages/pengaturan/edit/edit.php';
            break;

        case 'delete':
            include './pages/pengaturan/delete/delete.php';
            break;

        case 'main':
            include './pages/main/main.php';
            break;

        case 'add_main':
            include './pages/main/add_main/add_main.php';
            break;

        case 'edit_main':
            include './pages/main/edit_main/edit_main.php';
            break;

        case 'delete_main':
            include './pages/main/delete_main/delete_main.php';
            break;
    }
} else {
    include './pages/dashboard/dashboard.php';
}
