<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];

    $stmt = $pdo->prepare("INSERT INTO mata_pelajaran (nama) VALUES (?)");
    $stmt->execute([$nama]);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Mata Pelajaran</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Manajemen Mata Pelajaran</h1>
    <form method="POST">
        <input type="text" name="nama" placeholder="Nama Mata Pelajaran" required>
        <button type="submit">Tambah Mata Pelajaran</button>
    </form>

    <h2>Daftar Mata Pelajaran</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Mata Pelajaran</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM mata_pelajaran");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nama']}</td>
                </tr>";
        }
        ?>
    </table>
</body>
</html>
