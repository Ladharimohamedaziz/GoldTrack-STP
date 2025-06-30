@echo off
title Launching Satoripop Project (Laravel → Browser → VSCode)
echo Welcome to Goldtrack Project

REM 1
cd /d C:\Users\USER\Desktop\GoldTrack-STP\STP

REM 2 Open Laravel 
echo → Laravel 
start /B php artisan serve

REM Open Vs code
echo → VSCode
start code .

REM Open in Browser
echo → Browser
start http://127.0.0.1:8000


echo All set! You’re ready to work Mr ladhari.
pause
