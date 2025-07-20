-- Script de création de la base de données E-Library
-- À exécuter dans phpMyAdmin ou MySQL CLI

-- Créer la base de données si elle n'existe pas
CREATE DATABASE IF NOT EXISTS elibrary CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utiliser la base de données
USE elibrary;

-- Message de confirmation
SELECT 'Base de données elibrary créée avec succès!' AS Message;