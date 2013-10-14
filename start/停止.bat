cd %~dp0
@taskkill /f /im "ApacheMonitor.exe"
cls
httpd -k stop -n "DPL"
httpd -k uninstall -n "DPL"
pause
