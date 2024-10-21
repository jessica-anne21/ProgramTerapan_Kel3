<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_mata_pelajaran = $_POST['id_mata_pelajaran'];
    $kelas = $_POST['kelas'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];

    $stmt = $pdo->prepare("INSERT INTO jadwal (id_mata_pelajaran, kelas, hari, jam) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id_mata_pelajaran, $kelas, $hari, $jam]);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Jadwal</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Manajemen Jadwal</h1>
    <form method="POST">
        <select name="id_mata_pelajaran" required>
            <option value="">Pilih Mata Pelajaran</option>
            <?php
            $stmt = $pdo->query("SELECT * FROM mata_pelajaran");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id']}'>{$row['nama']}</option>";
            }
            ?>
        </select>
        <input type="text" name="kelas" placeholder="Kelas" required>
        <input type="text" name="hari" placeholder="Hari" required>
        <input type="text" name="jam" placeholder="Jam" required>
        <button type="submit">Tambah Jadwal</button>
    </form>

    <h2>Daftar Jadwal</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Mata Pelajaran</th>
            <th>Kelas</th>
            <th>Hari</th>
            <th>Jam</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT jadwal.*, mata_pelajaran.nama AS mata_pelajaran FROM jadwal JOIN mata_pelajaran ON jadwal.id_mata_pelajaran = mata_pelajaran.id");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['mata_pelajaran']}</td>
                    <td>{$row['kelas']}</td>
                    <td>{$row['hari']}</td>
                    <td>{$row['jam']}</td>
                </tr>";
        }
        ?>
    </table>
</body>
</html>

