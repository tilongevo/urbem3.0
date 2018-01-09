#!/bin/bash
yml=$(cd -P -- "$(dirname -- "$0")" && pwd -P)
yml="$yml/../app/config/common/version.yml"

version=`grep -A3 'version:' $yml | tail -n1 | awk '{ print $2}' | sed -e "s/'//g" `
version="$version $(date '+%Y%m%d%H%M')"

sed -i "s/\(.*version:.*\)/  version: '$version'/g" $yml