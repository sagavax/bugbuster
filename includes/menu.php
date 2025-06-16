<?php
   $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
   // Názov domény
   $host = $_SERVER['HTTP_HOST'];
   // Koreňová cesta (bez /includes napr.)
    $base = $protocol . $host."/bugbuster";
?>

<ul>
    <li><a href="<?= $base ?>/dashboard.php">Dashboard</a></li>
    <li><a href="<?= $base ?>/apps/index.php">Applications</a></li>
    <li><a href="<?= $base ?>/bugs/index.php">Bugs</a></li>
    <li><a href="<?= $base ?>/diary/index.php">Diary</a></li>
    <li><a href="<?= $base ?>/ideas/index.php">Ideas</a></li>
    <li><a href="<?= $base ?>/notes/index.php">Notes</a></li>
    <li><a href="<?= $base ?>/tasks/index.php">Tasks</a></li>
    <li><a href="<?= $base ?>/log/index.php">Logs</a></li>
    <li><a href="<?= $base ?>/about.php">About</a></li>
    <li><a href="<?= $base ?>/logout.php">Logout</a></li>
</ul>

