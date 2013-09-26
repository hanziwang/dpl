cd %~dp0
cls
@taskkill /f /im "ApacheMonitor.exe"
httpd -k stop -n "DPL"
httpd -k uninstall -n "DPL"
pause
