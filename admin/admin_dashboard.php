<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Dashboard Admin</h1>
    <nav>
        <ul>
            <li><a href="manage_students.php">Manajemen Siswa</a></li>
            <li><a href="manage_teachers.php">Manajemen Guru</a></li>
            <li><a href="manage_subjects.php">Manajemen Mata Pelajaran</a></li>
            <li><a href="manage_schedule.php">Manajemen Jadwal</a></li>
            <li><a href="manage_grades.php">Manajemen Nilai</a></li>
            <li><a href="report_card.php">Rapor Nilai Siswa</a></li>
        </ul>
    </nav>
</body>
</html>
