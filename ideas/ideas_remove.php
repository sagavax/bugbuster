<?php include "../includes/dbconnect.php";
      include "../includes/functions.php";
                    
        $idea_id = $_POST['idea_id'];

        //remove idea
        $delete_idea = "DELETE from ideas WHERE idea_id=$idea_id";
        $result = mysqli_query($link, $delete_idea) or die("MySQLi ERROR: ".mysqli_error($link));

        //remove comments
        $delete_comments = "DELETE from ideas_comments WHERE idea_id=$idea_id";
        $result = mysqli_query($link, $delete_comments) or die("MySQLi ERROR: ".mysqli_error($link));


        $diary_text="Minecraft IS: Ideas s id $idea_id bola vymazana ";
            $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
            $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

         echo "<script>alert('Minecraft IS: Ideas s id $idea_id vratend komentarov bola vymazana');
              window.location.href='ideas.php';
              </script>";