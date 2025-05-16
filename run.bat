@echo off
IF [%1] NEQ [] goto CHOICE_%1

CHOICE /C wats /N /M "Elija: [W]eb, [A]PI, [T]odos o [S]alir"

goto CHOICE_%ERRORLEVEL%
:CHOICE_4
goto :eof

:CHOICE_3
call :CHOICE_1
call :CHOICE_2
goto :eof

:CHOICE_1
Start "WEB" php -S localhost:4200 -t.\Web\
goto :eof

:CHOICE_2
Start "API" php -S localhost:4321 -t.\API\ -f.\API\index.php 
goto :eof