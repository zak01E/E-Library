@echo off
cd "C:\Users\zakar\Downloads\Projets digitaux\E-Library"
echo Starting Laravel server for Mama Ecole...
echo.
echo Access the application at:
echo   - Main: http://localhost:8000
echo   - Test Twilio: http://localhost:8000/mama-ecole/test-twilio
echo   - Dashboard: http://localhost:8000/mama-ecole/dashboard
echo.
php artisan serve --host=localhost --port=8000