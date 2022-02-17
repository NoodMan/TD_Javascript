<?php
define( // creation de la constante
    'IS_AJAX',
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
); // == pour faire une comparaison && renvoie vrai si les deux opérandes sont vrai

// var_dump($_SERVER);
// die('-->Je suis ici<--');



if (!IS_AJAX) { // si faux 
    die('Oups restricted access 🚫');
}

// var_dump($_POST);
// die('-->Je suis ici<--');

$file           = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : ''; // tmp_name chemin temporaire
$reponses       = ['error' => 'false']; //change valeur en cas d'erreur
$file_name      = $_POST['file_name']; // nom du dossier 

// pas neccessaire car doublon avec la ligne $file
// if (isset($_POST['file'])) {

//     if ($_POST['file'] === 'undefined') {
//         $reponses[] = 'nonewfiles';
//     }
// } // pas neccessaire car doublon avec la ligne $file



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
    } else { // transforme ça en ternaire... 
        $authorized_format_file = [
            "image/jpeg", // on indique le type de fichier autoriser 
            "image/jpg",
            "image/png",
        ];

        if (!in_array($_FILES['file']["type"], $authorized_format_file)) { // si la valeur n'existe pas dans notre tableau
            $reponses[] = 'Format invalide 🚫';
            _addError();
        }


        $folder_user = "img_" . ((string) rand(10000, 990000) . '_' . time()); //création de nom de dossier aléatoire + l'heure

        while (is_dir($folder_user)) { // is_dir indique vrai si le nom de dossier aléatoire existe ou pas
            $folder_user = "img_" . ((string) rand(10000, 990000) . '_' . time()); // création d'un nouveau nom si il existe deja  
        }

        $create_dir = mkdir($folder_user, 0755); // les permissions  : 7 utilisateur full droits. 5 les droits des gens du groupe de l'utilisatuer. 5 tout le reste du monde 

        if (move_uploaded_file($_FILES['file']['tmp_name'], $folder_user . '/' . $file_name)) { // si on veux un autre chemin modifier '/'
            $reponses[] = 'Convert successfully 💪🏼'; //premier cle 0
            $command = escapeshellcmd('python3 mail.py');
            $output = shell_exec($command);
            echo $output;
            $reponses[] = "a confirmation email has been sent to you... <br>  /!\ check spam, please! "; // deuxieme clé 1

        } else { // transforme ça en ternaire... 
            $reponses[] = 'Convert with errors 😞';
        }
    }
}



if ($reponses['error'] = 'false') {
    unset($reponses['error']);
}

print json_encode($reponses);
