<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

// Proses penambahan atau pengeditan guru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'];
    $mata_pelajaran = $_POST['mata_pelajaran'];
    $telepon = $_POST['telepon'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE guru SET nama = ?, mata_pelajaran = ?, telepon = ? WHERE id = ?");
        $stmt->execute([$nama, $mata_pelajaran, $telepon, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO guru (nama, mata_pelajaran, telepon) VALUES (?, ?, ?)");
        $stmt->execute([$nama, $mata_pelajaran, $telepon]);
    }
}

// Proses penghapusan guru
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM guru WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_teachers.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Guru</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Manajemen Guru</h1>

    <?php
    $edit = isset($_GET['edit']);
    $guru = null;
    if ($edit) {
        $id = $_GET['edit'];
        $stmt = $pdo->prepare("SELECT * FROM guru WHERE id = ?");
        $stmt->execute([$id]);
        $guru = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $guru['id'] ?? '' ?>">
        <input type="text" name="nama" placeholder="Nama Guru" value="<?= $guru['nama'] ?? '' ?>" required>
        <input type="text" name="mata_pelajaran" placeholder="Mata Pelajaran" value="<?= $guru['mata_pelajaran'] ?? '' ?>" required>
        <input type="text" name="telepon" placeholder="Telepon" value="<?= $guru['telepon'] ?? '' ?>">
        <button type="submit"><?= $edit ? 'Update' : 'Tambah' ?> Guru</button>
    </form>

    <h2>Daftar Guru</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Mata Pelajaran</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM guru");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['mata_pelajaran']}</td>
                    <td>{$row['telepon']}</td>
                    <td>
                        <a href='manage_teachers.php?edit={$row['id']}'>Edit</a> |
                        <a href='manage_teachers.php?delete={$row['id']}'>Delete</a>
                    </td>
                </tr>";
        }
        ?>
    </table>
</body>
</html>
