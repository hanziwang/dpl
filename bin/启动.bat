httpd -k install -n "DPL" -f "conf/httpd.conf"
httpd -k start -n "DPL" -f "conf/httpd.conf"
pause
start http://127.0.0.1:8000/admin