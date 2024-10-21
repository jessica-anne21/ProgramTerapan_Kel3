<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

// Proses penambahan atau pengeditan siswa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    if ($id) {
        // Jika ID ada, maka lakukan update data
        $stmt = $pdo->prepare("UPDATE siswa SET nama = ?, kelas = ?, alamat = ?, telepon = ? WHERE id = ?");
        $stmt->execute([$nama, $kelas, $alamat, $telepon, $id]);
    } else {
        // Jika ID tidak ada, tambahkan data baru
        $stmt = $pdo->prepare("INSERT INTO siswa (nama, kelas, alamat, telepon) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama, $kelas, $alamat, $telepon]);
    }
}

// Proses penghapusan siswa
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM siswa WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_students.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Siswa</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Manajemen Siswa</h1>

    <?php
    // Cek apakah dalam mode edit
    $edit = isset($_GET['edit']);
    $siswa = null;
    if ($edit) {
        $id = $_GET['edit'];
        $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id = ?");
        $stmt->execute([$id]);
        $siswa = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $siswa['id'] ?? '' ?>">
        <input type="text" name="nama" placeholder="Nama Siswa" value="<?= $siswa['nama'] ?? '' ?>" required>
        <input type="text" name="kelas" placeholder="Kelas" value="<?= $siswa['kelas'] ?? '' ?>" required>
        <textarea name="alamat" placeholder="Alamat"><?= $siswa['alamat'] ?? '' ?></textarea>
        <input type="text" name="telepon" placeholder="Telepon" value="<?= $siswa['telepon'] ?? '' ?>">
        <button type="submit"><?= $edit ? 'Update' : 'Tambah' ?> Siswa</button>
    </form>

    <h2>Daftar Siswa</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM siswa");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['kelas']}</td>
                    <td>{$row['alamat']}</td>
                    <td>{$row['telepon']}</td>
                    <td>
                        <a href='manage_students.php?edit={$row['id']}'>Edit</a> |
                        <a href='manage_students.php?delete={$row['id']}'>Delete</a>
                    </td>
                </tr>";
        }
        ?>
    </table>
</body>
</html>
