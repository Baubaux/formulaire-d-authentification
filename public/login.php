<?php

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

// activation du système d'autoloading de Composer
require_once __DIR__.'/../vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new FilesystemLoader(__DIR__.'/../templates');

// instanciation du moteur de template
$twig = new Environment($loader, [
    // activation du mode debug
    'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
]);

// chargement de l'extension DebugExtension
$twig->addExtension(new DebugExtension());

// traitement des données
$errors = [];
$password = [];

if ($_POST) {

    $maxLength = 190;

    if (empty($_POST['login'])) {
        $errors['login'] = 'merci de renseigner ce champ';
    } elseif (strlen($_POST['login']) >= 190) {
        $errors['login'] = "merci de renseigner les champs en respectant les conditions";
    } 

    $minLenght = 8;
    $maxLength = 32;

    if (empty($_POST['password'])) {
        $errors['password'] = 'merci de renseigner ce champ';
    } elseif (strlen($_POST['password']) <= 8 || strlen($_POST['password']) >= 32) {
        $errors['password'] = "merci de renseigner les champs en respectant les conditions";
    } elseif (preg_match('/[^A-Za-z0-9]/', $_POST['password']) === 0) {
        $errors['password'] = "merci de renseigner les champs en respectant les conditions";
    }
}

// affichage du rendu d'un template
echo $twig->render('login.html.twig', [
    // transmission de données au template
    'errors' => $errors,
]);