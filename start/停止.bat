cd %~dp0
cls
httpd -k stop -n "DPL"
httpd -k uninstall -n "DPL"
pause
