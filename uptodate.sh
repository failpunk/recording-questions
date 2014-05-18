#!/bin/bash         

chmod 777 ./sphinx-stop.sh
./sphinx-stop.sh

find ./ ! -name "uptodate.sh" ! -name "symfony" -exec rm -rf {} \;

svn export --force http://formapro@qaweb.svn.beanstalkapp.com/recording/trunk .

chmod 777 ./uptodate.sh

chmod -R 777 config 

cp -R config.forma/* config/
mv config/app.yml apps/recording/config/app.yml

chmod -R 777 config
chmod -R 777 data
chmod -R 777 log
chmod -R 777 cache 

chmod 777 ./symfony

./symfony fix
./symfony cc 
./symfony propel:build-all-load
./symfony fix

chmod 777 ./sphinx-reindex.sh
./sphinx-reindex.sh


date "+%d %b %Y %H:%S" > ./web/update.txt
