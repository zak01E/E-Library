<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
    'password' => 'Le mot de passe fourni est incorrect.',
    'throttle' => 'Trop de tentatives de connexion. Veuillez réessayer dans :seconds secondes.',

    // Custom authentication messages
    'login' => [
        'title' => 'Connexion',
        'subtitle' => 'Accédez à votre bibliothèque personnelle',
        'email' => 'Adresse email',
        'password' => 'Mot de passe',
        'remember' => 'Se souvenir de moi',
        'forgot_password' => 'Mot de passe oublié ?',
        'submit' => 'Se connecter',
        'no_account' => 'Pas encore de compte ?',
        'create_account' => 'Créer un compte',
        'other_login' => 'Vous avez un autre type de compte ?',
        'author_login' => 'Connexion Auteur',
        'admin_login' => 'Connexion Admin',
    ],

    'register' => [
        'title' => 'Créer un compte',
        'subtitle' => 'Rejoignez notre communauté de lecteurs',
        'name' => 'Nom complet',
        'email' => 'Adresse email',
        'password' => 'Mot de passe',
        'password_confirmation' => 'Confirmer le mot de passe',
        'submit' => 'Créer mon compte',
        'already_registered' => 'Vous avez déjà un compte ?',
        'login' => 'Se connecter',
        'terms' => 'J\'accepte les conditions d\'utilisation et la politique de confidentialité',
    ],

    'forgot_password' => [
        'title' => 'Mot de passe oublié',
        'subtitle' => 'Pas de problème ! Nous vous enverrons un lien de réinitialisation',
        'email' => 'Adresse email',
        'submit' => 'Envoyer le lien de réinitialisation',
        'back_to_login' => 'Retour à la connexion',
        'remember_password' => 'Vous vous souvenez de votre mot de passe ?',
    ],

    'reset_password' => [
        'title' => 'Nouveau mot de passe',
        'subtitle' => 'Créez un mot de passe sécurisé pour votre compte',
        'email' => 'Adresse email',
        'password' => 'Nouveau mot de passe',
        'password_confirmation' => 'Confirmer le mot de passe',
        'submit' => 'Réinitialiser le mot de passe',
    ],

    'confirm_password' => [
        'title' => 'Zone sécurisée',
        'subtitle' => 'Confirmez votre mot de passe pour continuer',
        'password' => 'Mot de passe actuel',
        'submit' => 'Confirmer et continuer',
    ],

    'verify_email' => [
        'title' => 'Vérifiez votre email',
        'subtitle' => 'Nous avons envoyé un lien de vérification à votre adresse',
        'resend' => 'Renvoyer l\'email de vérification',
        'logout' => 'Se déconnecter',
        'verification_sent' => 'Un nouveau lien de vérification a été envoyé à votre adresse email.',
    ],

];
