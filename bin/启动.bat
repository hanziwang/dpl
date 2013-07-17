httpd -k install -n "DPL" -f "bin/conf/httpd.conf"
httpd -k start -n "DPL" -f "bin/conf/httpd.conf"
pause
start http://localhost:8000