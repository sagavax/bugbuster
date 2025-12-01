 <?php    

    include "../includes/dbconnect.php";
    include "../includes/functions.php";

    $app_id = $_POST['app_id'];


    $itemsPerPage = 10;
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $itemsPerPage;  
            
    $app_name = strtolower(getAppName($app_id));

    //echo "$app_name";
    $get_notes = "SELECT * FROM notes WHERE note_application='$app_name' ORDER BY note_id DESC LIMIT $offset, $itemsPerPage";
    $result_notes = mysqli_query($link, $get_notes) or die(mysqli_error($link));
        while ($row_notes = mysqli_fetch_array($result_notes)) {
            $note_id = $row_notes['note_id'];
            $note_title = $row_notes['note_title'];
            $note_text = $row_notes['note_text'];
            $note_date = $row_notes['created_date'];
            echo "<div class='note' data-note-id=$note_id>";
                echo "<div class='note_title'>$note_title</div>";
                echo "<div class='note_text'>$note_text</div>";
                echo "<div class='note_date'>$note_date</div>";
            echo "</div>";
        }