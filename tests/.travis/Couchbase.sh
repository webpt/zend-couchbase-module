#!/usr/bin/env bash

# @src https://github.com/matthiasmullie/scrapbook/blob/1.4.3/tests/.travis/Couchbase.sh

docker run -d -p 11210:11210 webpt/couchbase-server

pecl uninstall couchbase

sudo wget -O/etc/apt/sources.list.d/couchbase.list http://packages.couchbase.com/ubuntu/couchbase-ubuntu1204.list
sudo wget -O- http://packages.couchbase.com/ubuntu/couchbase.key | sudo apt-key add -
sudo apt-get update
sudo apt-get install -y libcouchbase2-libevent libcouchbase-dev
pecl install pcs-1.3.1 couchbase --alldeps
