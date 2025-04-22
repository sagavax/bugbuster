<?php 
  include "../includes/dbconnect.php";
  include "../includes/functions.php";  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/notes.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script type="text/javascript" defer src="../js/notes.js?<?php echo time(); ?>"></script>
    <title>BugBuster - notes</title>
    <link rel='shortcut icon' href='../letter-b.png'>
</head>
<body>
<body>
           <div class="main">
           <?php include ("../includes/header.php") ?>
           <div class="content">
              <div class="list">
               <div class="new_note">
                   <input type="text" placeholder="Title" name="note_title" autocomplete="off">
                   <textarea placeholder="Type some text here..." name="note_text"></textarea>
                    <div class="add_note_action">
                   <button type="button" name="add_note" class="button small_button">Add Note</button>
                   </div>
               </div><!-- new_note -->
               
               <div class="notes">
                <?php
                    $get_notes = "SELECT * from notes ORDER BY created_date DESC";
                    $result = mysqli_query($link, $get_notes) or die("MySQLi ERROR: ".mysqli_error($link));
                    while ($row = mysqli_fetch_array($result)) {
                        $note_id = $row['note_id'];
                        $note_title = $row['note_title'];
                        $note_text = $row['note_text'];
                        $note_date = $row['created_date'];
                        $note_application = $row['note_application'];

                        echo "<div class='note' note-id=$note_id>";
                          echo "<div class='note_title'>$note_title</div>";
                          echo "<div class='note_text'>$note_text</div>";
                          echo "<div class='note_action'>";
                          if($note_application != ""){
                            //echo "<div class='note_application'>$note_application</div>";
                            echo "<button type='button' class='button small_button' name='note_application'>$note_application</button>";
                          } else {
                            //echo "<div class='note_application'><button type='button'><i class='fa fa-plus'></i> application</button></div>";
                            echo "<button type='button' class='button small_button' name='note_application'><i class='fa fa-plus'></i> application</button>";
                          }
                          echo "<button class='button small_button' name='delete_note' title='Delete Note'><i class='fa fa-times'></i></button>";
                          echo "</div>"; // note_action
                          
                        echo "</div>";// note
                    }

                ?>
               </div><!-- notes --> 

             </div><!-- list-->
           </div><!-- content -->
           </div><!-- main -->  
    <dialog class="modal_change_app">
       <?php
            echo "<ul>";
            $get_apps = "SELECT * FROM apps";
            $result_apps = mysqli_query($link, $get_apps) or die(mysqli_error($link));
            while ($row_apps = mysqli_fetch_array($result_apps)) {
                $app_id = $row_apps['app_id'];
                $app_name = $row_apps['app_name'];
                echo "<li data-app-id=$app_id>$app_name</li>";
            } 
            echo "</ul>";          
            ?>          
    </dialog>
</body>
</html>