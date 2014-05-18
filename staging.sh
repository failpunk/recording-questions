#!/bin/bash         

svn update

./symfony cc

#chmod 777 ./sphinx-stop.sh
#./sphinx-stop.sh

#find ./ ! -name "staging.sh" ! -name "symfony" -exec rm -rf {} \;

#svn co --force http://qaweb@qaweb.svn.beanstalkapp.com/recording/trunk .

#chmod 777 ./staging.sh
#chmod 777 ./cc.sh

#chmod -R 777 config

#cp -R config.forma/* config/
#mv config/app.yml apps/recording/config/app.yml

#chmod -R 777 config
#chmod -R 777 data
#chmod -R 777 log
#chmod -R 777 cache

#chmod 777 ./symfony

#./symfony fix
#./symfony cc
#./symfony propel:build-model
#./symfony propel:build-forms
#./symfony propel:build-filters
#./symfony propel:build-sql
./symfony fix

# create the sitemap again
#./symfony recording:sitemap --env=prod

#chmod 777 ./sphinx-reindex.sh
#./sphinx-reindex.sh

# dump the latest svn info to a file
svn info http://qaweb@qaweb.svn.beanstalkapp.com/recording/trunk > svn.info

date "+%d %b %Y %H:%S" > ./web/update.txt
