@echo off
rem Esto cambia a que la terminal muestre UTF8 
rem y como el programa tiene mensage de salida lo redirecionamos a la basura
@chcp 65001 >nul
SET "tab=   "
IF [%1] NEQ [] goto CHOICE_%1
echo %tab%  ╭────────────────────────────────────╮
echo %tab%  │          Elije una opcion          │
echo %tab%  ╞════════════════════════════════════╡
echo %tab%  │          [S]alir                   │
echo %tab%  │          [W]eb                     │
echo %tab%  │          [A]PI                     │
echo %tab%  │          [T]odos                   │
echo %tab%  ╰────────────────────────────────────╯

rem echo ╭─╮╰─╯├─┤│ ┌─┐└─┘ ┨ ┃ ┕━┛ ┒ ╞═╡
CHOICE /C swat /N /M "  " >nul

goto CHOICE_%ERRORLEVEL%
:CHOICE_1
goto :eof

:CHOICE_4
call :CHOICE_2
call :CHOICE_3
goto :eof

:CHOICE_2
Start "WEB" php -S localhost:4200 -t.\Web\
goto :eof

:CHOICE_3
Start "API" php -S localhost:4321 -t.\API\ -f.\API\index.php 
goto :eof