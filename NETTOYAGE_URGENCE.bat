@echo off
cls
echo =====================================
echo    NETTOYAGE D'URGENCE - DISQUE PLEIN
echo =====================================
echo.
echo ATTENTION: Votre disque C: est PLEIN a 100%%!
echo.
echo Ce script va nettoyer:
echo - Les logs Laravel (16 MB)
echo - Le cache Laravel
echo - Les fichiers temporaires
echo.
pause

cd /d "C:\Users\zakar\Downloads\Projets digitaux\E-Library"

echo.
echo 1. Suppression des logs Laravel...
del /f storage\logs\*.log
echo > storage\logs\laravel.log
echo    [OK] Logs nettoyes

echo.
echo 2. Nettoyage du cache Laravel...
php artisan cache:clear
php artisan config:clear
php artisan view:clear
echo    [OK] Cache nettoye

echo.
echo 3. Nettoyage des sessions...
del /f /q storage\framework\sessions\*
echo    [OK] Sessions nettoyees

echo.
echo 4. Nettoyage du cache des vues...
del /f /q storage\framework\views\*.php
echo    [OK] Vues compilees nettoyees

echo.
echo =====================================
echo    NETTOYAGE TERMINE
echo =====================================
echo.
echo Maintenant, liberez plus d'espace:
echo.
echo 1. Videz la Corbeille Windows
echo 2. Nettoyez les telechargements
echo 3. Utilisez Nettoyage de disque Windows:
echo    - Win+R, tapez: cleanmgr
echo    - Selectionnez C:
echo    - Cochez toutes les cases
echo.
pause