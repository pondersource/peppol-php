php console.php maintenance:install --admin-user $USER --admin-pass $PASS --database "mysql" --database-name "nextcloud" --database-user "root" --database-pass "eilohtho9oTahsuongeeTh7reedahPo1Ohwi3aek" --database-host "$DBHOST"
php console.php app:disable firstrunwizard
php console.php app:enable sciencemesh
sed -i "8 i\      1 => 'nc1.docker'," /var/www/html/config/config.php
sed -i "9 i\      2 => 'nc2.docker'," /var/www/html/config/config.php
sed -i "10 i\      3 => 'nc1.pondersource.net'," /var/www/html/config/config.php
sed -i "11 i\      4 => 'nc2.pondersource.net'," /var/www/html/config/config.php
sed -i "3 i\  'allow_local_remote_servers' => true," config/config.php
