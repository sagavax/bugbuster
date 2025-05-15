<?php
    include "../includes/dbconnect.php";
    include "../includes/functions.php";
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App logs</title>
        <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
        <link rel="stylesheet" href="../css/log.css?<?php echo time(); ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link rel='shortcut icon' href='../letter-b.png'>
    </head>
    <body>
        <div class="main">
            <?php include ("../includes/header.php") ?>
            <div class="content">
                <div class="list">
                    <h3>App logs</h3>
                    <?php
                     $itemsPerPage = 10;

                     $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                     $offset = ($current_page - 1) * $itemsPerPage;

                    $get_logs = "SELECT * FROM app_log ORDER BY id DESC LIMIT $itemsPerPage OFFSET $offset";     
                    $run_logs = mysqli_query($link, $get_logs) or die(mysqli_error($link));
                    while($row_logs = mysqli_fetch_array($run_logs)){
                        $id = $row_logs['id'];
                        $log_text = $row_logs['diary_text'];
                        $date = $row_logs['date_added'];

                        echo "<div class='log'>";
                            echo "<div class='log_text'>$log_text</div>";
                            echo "<div class='log_date'>$date</div>";
                        echo "</div>";
                    }  

                    // Calculate the total number of pages
                    $sql = "SELECT COUNT(*) as total FROM app_log";
                    $result = mysqli_query($link, $sql);
                    
                    $totalItems = 0; // Predvolene nulová hodnota
                    
                    if ($row = mysqli_fetch_array($result)) {
                        $totalItems = (int) $row['total']; // Zaistenie, že hodnota je celé číslo
                    }
                    
                    // Výpočet počtu strán
                    $totalPages = ($totalItems > 0) ? ceil($totalItems / $itemsPerPage) : 1;
                    
                    // Zobrazenie stránkovania
                    echo '<div class="pagination">';
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<a href="?page=' . $i . '">' . $i . '</a>'; // Opravené úvodzovky
                    }
                    echo '</div>';
                    ?>
                </div><!-- /.list-->
            </div><!-- /.content -->
        </div><!-- /.main--> 
        
    </body>
</html>