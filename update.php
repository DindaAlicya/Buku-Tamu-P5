<?php

require_once "Connection.php";

$db = getConnection();

$newData = [
    "kehadiran" => "sudah hadir",
  ];

  $statement = $db->prepare("UPDATE siswa3 SET kehadiran = ? WHERE nis = ?");

  $statement->execute([
    $newData["kehadiran"],
    10922,
  ]);
  
  echo "Berhasil update data";