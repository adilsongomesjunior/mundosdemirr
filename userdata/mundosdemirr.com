--- 
byteslog: /usr/local/apache/domlogs/mundosdemirr.com-bytes_log
customlog: 
  - 
    format: combined
    target: /etc/apache2/logs/domlogs/mundosdemirr.com
  - 
    format: "\"%{%s}t %I .\\n%{%s}t %O .\""
    target: /etc/apache2/logs/domlogs/mundosdemirr.com-bytes_log
documentroot: /home/mundosde/public_html
group: mundosde
hascgi: 0
homedir: /home/mundosde
ifmodulealiasmodule: 
  scriptalias: 
    - 
      path: /home/mundosde/public_html/cgi-bin/
      url: /cgi-bin/
ifmoduleconcurrentphpc: {}

ifmoduleincludemodule: 
  directoryhomemundosdepublichtml: 
    ssilegacyexprparser: 
      - 
        value: " On"
ifmoduleitkc: {}

ifmodulelogconfigmodule: 
  ifmodulelogiomodule: 
    customlog: 
      - 
        format: "\"%{%s}t %I .\\n%{%s}t %O .\""
        target: /usr/local/apache/domlogs/mundosdemirr.com-bytes_log
ifmodulemodincludec: 
  directoryhomemundosdepublichtml: 
    ssilegacyexprparser: 
      - 
        value: " On"
ifmodulemodsuphpc: 
  group: mundosde
ifmoduleuserdirmodule: 
  ifmodulempmitkc: 
    ifmoduleruidmodule: {}

include: 
  - 
    include: "\"/usr/local/apache/conf/userdata/*.conf\""
  - 
    include: "\"/usr/local/apache/conf/userdata/*.owner-root\""
  - 
    include: "\"/usr/local/apache/conf/userdata/std/*.conf\""
  - 
    include: "\"/usr/local/apache/conf/userdata/std/*.owner-root\""
  - 
    include: "\"/usr/local/apache/conf/userdata/std/2/*.conf\""
  - 
    include: "\"/usr/local/apache/conf/userdata/std/2/*.owner-root\""
ip: 209.239.121.100
owner: root
phpopenbasedirprotect: 1
port: 80
scriptalias: 
  - 
    path: /home/mundosde/public_html/cgi-bin
    url: /cgi-bin/
serveradmin: webmaster@mundosdemirr.com
serveralias: mail.mundosdemirr.com www.mundosdemirr.com
servername: mundosdemirr.com
usecanonicalname: 'Off'
user: mundosde
userdirprotect: ''
