cd %~dp0
cls
@start "" "ApacheMonitor.exe"
httpd -k install -n "DPL"
httpd -k start -n "DPL"
pause
start http://127.0.0.1:8000/admin