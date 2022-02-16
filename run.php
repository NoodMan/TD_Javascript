<?php
define( // creation de la constante
    'IS_AJAX',
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
); // == pour faire une comparaison

// var_dump($_SERVER);
// die('-->Je suis ici<--');



if (!IS_AJAX) { // si faux 
    die('Restricted access');
}
// var_dump($_POST);
// die('-->Je suis ici<--');

$file           = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : '';
$reponses       = ['error' => 'false']; 
$file_name      = $_POST['file_name'];


if (isset($_POST['file'])) {

    if ($_POST['file'] === 'undefined') {
        $reponses[] = 'nonewfiles';
    }
}



function _addError()
{
    $reponses['error'] = 'true';
    print json_encode($reponses);
    exit;
} 


if ($file !== '') {
    if (0 < $_FILES['file']['error']) {
        _addError();
        $reponses[] = 'Erreur d\'upload ‼️';
    } else {
        $authorized_format_file = [
            "image/jpeg", // on indique le type de fichier autoriser 
            "image/jpg",
            "image/png",
        ];

        if (!in_array($_FILES['file']["type"], $authorized_format_file)) {
            $reponses[] = 'Format invalide 🚫';
            _addError();
        }


        $folder_user = "img_" . ((string) rand(10000, 990000) . '_' . time()); 

        while (is_dir($folder_user)) {
          // $folder_user pas besoin repetition   
        }

        $create_dir = mkdir($folder_user, 0755); // 7 utilisateur du site 5 les visiteurs du site 

        if (move_uploaded_file($_FILES['file']['tmp_name'], $folder_user . '/' . $file_name)) { // si on veux un autre chemin modifier '/'
            $reponses[] = 'Convert successfully 💪🏼';
        } else {
            $reponses[] = 'Convert with errors 😞';
        }
    }
}

if ($reponses['error'] = 'false') {
    unset($reponses['error']);
}

print json_encode($reponses);





 


