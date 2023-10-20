#!/bin/bash
set -e
set -u

function create_user_and_database() {
	local database=$1
  echo "[HeyLOG] Creating database $database"
  psql -v ON_ERROR_STOP=1 -U "$POSTGRES_USER" <<-EOSQL
      CREATE DATABASE $database OWNER = $POSTGRES_USER ENCODING = 'UTF8' LC_COLLATE = 'en_US.utf8' LC_CTYPE = 'en_US.utf8' TABLESPACE = pg_default CONNECTION LIMIT = -1;
EOSQL
}

if [ -n "$POSTGRES_MULTIPLE_DATABASES" ]; then
	echo "[HeyLOG] Multiple database creation requested: $POSTGRES_MULTIPLE_DATABASES"
	for db in $(echo $POSTGRES_MULTIPLE_DATABASES | tr ',' ' '); do
    if [ "$( psql -U "$POSTGRES_USER" -tAc "SELECT 1 FROM pg_database WHERE datname='$db'" )" = '1' ]
    then
      echo "[HeyLOG] $db Already Exists, skipping creation"
    else
      PGPASSWORD=$POSTGRES_PASSWORD create_user_and_database $db
      echo "[HeyLOG] DB $db created"
    fi
	done
	echo "[HeyLOG] All done"
fi
