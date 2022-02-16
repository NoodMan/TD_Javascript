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

$file           = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : '';
$reponses       = ['error' => 'false']; // ???? prk ça fonctionne pas error lors de l'enregistrement de l'image
$file_name      = $_POST['file_name'];

// var_dump($_POST);
// die('-->Je suis ici<--');

if (isset($_POST['file'])) {

    if ($_POST['file'] === 'undefined') {
        $reponses[] = 'nonewfiles';
    }
}

if ($file !== '') {
    if (0 < $_FILES['file']['error']) {
        _addError();
        $reponses[] = 'Erreur d\'upload';
    } else {
        $authorized_format_file = [
            "image/jpeg", // on indique le type de fichier autoriser 
            "image/jpg",
        ];

        if (!in_array($_FILES['file']["type"], $authorized_format_file)) {
            $reponses[] = 'Format invalide';
            _addError();
        }


        $folder_user = "img_" . ((string) rand(10000, 90000) . '_' . time());

        while (is_dir($folder_user)) {
            $folder_user = "img_" . ((string) rand(10000, 90000) . '_' . time());
        }

        $create_dir = mkdir($folder_user, 0755); // 7 utilisateur du site 5 les visiteurs du site 

        if (move_uploaded_file($_FILES['file']['tmp_name'], $folder_user . '/' . $file_name)) {
            $reponses[] = 'Convert successfully';
        } else {
            $reponses[] = 'Convert with errors';
        }
    }
}

if ($responses['error'] = 'false') {
    unset($responses['error']);
}

print json_encode($reponses);

function _addError()
{
    $reponses['error'] = 'true';
    print json_encode($reponses);
    exit;
}
