<?php
header('Content-Type: application/json'); // Nastavenie správneho JSON headeru

include "includes/dbconnect.php";
include "includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Skontrolujeme, či request obsahuje JSON alebo klasické POST dáta
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, true);

    // Použijeme JSON, ak je dostupný, inak $_POST
    $note_title = trim($input['note_title'] ?? $_POST['note_title'] ?? '');
    $note_text = trim($input['note_text'] ?? $_POST['note_text'] ?? '');

    // Opravená validácia (kontrolujeme aj title, nie len text)
    if (empty($note_title) || empty($note_text)) {
        echo json_encode(['success' => false, 'message' => 'Title and text are required!']);
        exit; // Koniec skriptu po odoslaní odpovede
    }

    // Použitie prepared statements pre lepšiu bezpečnosť
    $stmt = $link->prepare("INSERT INTO notes (note_title, note_text, created_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $note_title, $note_text);
    
    if ($stmt->execute()) {
        // Logovanie do app_log
        $diary_text = "Bola pridaná nová poznámka";
        $log_stmt = $link->prepare("INSERT INTO app_log (diary_text,date_added) VALUES (?, NOW())");
        $log_stmt->bind_param("s", $diary_text);
        $log_stmt->execute();
        $log_stmt->close();

        echo json_encode(['success' => true, 'message' => 'Note added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding note: ' . $stmt->error]);
    }

    $stmt->close();
    $link->close();
    exit; // Koniec skriptu po vykonaní operácií
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit; // Koniec skriptu, ak je metóda iná ako POST
}
?>
