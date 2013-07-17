cd bin
httpd -k install -n "DPL" -f "bin/conf/httpd.conf"
httpd -k start -n "DPL" -f "bin/conf/httpd.conf"
pause
start http://127.0.0.1:8000/admin