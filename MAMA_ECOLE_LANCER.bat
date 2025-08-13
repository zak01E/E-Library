@echo off
cls
echo =====================================
echo    MAMA ECOLE - DEMARRAGE
echo =====================================
echo.
echo Demarrage du systeme Mama Ecole...
echo.

REM Aller dans le dossier E-Library
cd /d "C:\Users\zakar\Downloads\Projets digitaux\E-Library"

REM Afficher les URLs
echo =====================================
echo    ACCES MAMA ECOLE
echo =====================================
echo.
echo Une fois le serveur demarre, accedez a:
echo.
echo  PRINCIPAL:
echo  http://localhost:8000/mama-ecole
echo.
echo  TABLEAU DE BORD:
echo  http://localhost:8000/mama-ecole/dashboard
echo.
echo  TEST SMS/APPELS:
echo  http://localhost:8000/mama-ecole/test-twilio
echo.
echo  GESTION PARENTS:
echo  http://localhost:8000/mama-ecole/parents
echo.
echo =====================================
echo.
echo Demarrage du serveur Laravel...
echo Appuyez sur Ctrl+C pour arreter
echo.

REM Démarrer le serveur
php artisan serve --host=localhost --port=8000