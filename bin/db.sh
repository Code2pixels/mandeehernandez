#!/bin/bash
DATABASE_DUMPS_DIR="$PWD/database-dumps"

import() {
  FILE_TO_IMPORT=$1
  MYSQL_IMPORT_COMMAND='mysql --host $DB_HOST --user $DB_USER -p$DB_PASSWORD $DB_NAME < '

  mkdir -p $DATABASE_DUMPS_DIR

  if ! [ "$(ls -A $DATABASE_DUMPS_DIR)" ]; then
    echo "No database dumps found to import"
    exit 1;
  fi

  if [ -z "$FILE_TO_IMPORT" ]; then
    cd database-dumps
    printf "Please select the database dump to import:\n"
    select FILE_TO_IMPORT in *.sql; do test -n "$FILE_TO_IMPORT" && break; echo ">>> Invalid Selection"; done
    cd ..
  else
    if ! test -f "$DATABASE_DUMPS_DIR/$FILE_TO_IMPORT"; then
      echo "File at $DATABASE_DUMPS_DIR/$FILE_TO_IMPORT doesn't exist"
      exit 1;
    fi
  fi

  echo "Restoring database at ${DATABASE_DUMPS_DIR}/${FILE_TO_IMPORT}"

  if [ -f ".env" ]; then
    MYSQL_IMPORT_COMMAND+="/database-dumps/${FILE_TO_IMPORT}"
    export UID
    docker-compose exec mysql bash -c "$MYSQL_IMPORT_COMMAND" || { echo "Failed to execute mysql import command in mysql container"; exit 1; }
  else
    MYSQL_IMPORT_COMMAND+="${PWD}/${FILE_TO_IMPORT}"
    bash -c "$MYSQL_IMPORT_COMMAND" || { echo "Failed to execute mysql import command"; exit 1; }
  fi
}

dump() {
  MYSQLDUMP_NO_DATA_COMMAND='mysqldump \
    --add-drop-table \
    --comments \
    --create-options \
    --dump-date \
    --no-autocommit \
    --routines \
    --default-character-set=utf8 \
    --set-charset \
    --triggers \
    --no-tablespaces \
    --single-transaction \
    --no-data $DB_NAME \
    --host $DB_HOST \
    --user $DB_USER \
    -p$DB_PASSWORD >> '

  MYSQLDUMP_COMMAND='mysqldump \
    --quick \
    --extended-insert \
    --insert-ignore \
    --add-drop-table \
    --comments \
    --create-options \
    --dump-date \
    --no-autocommit \
    --routines \
    --default-character-set=utf8 \
    --set-charset \
    --triggers \
    --no-tablespaces \
    --no-create-info \
    --host $DB_HOST \
    --user $DB_USER \
    -p$DB_PASSWORD \
    $DB_NAME >> '

  mkdir -p $DATABASE_DUMPS_DIR

  TIMESTAMP=$(date '+%m%d%Y%H%M%S');

  MYSQLDUMP_OUTPUT_FILE_PATH="database.sql"

  if [ -f ".env" ]; then
    MYSQLDUMP_OUTPUT_FILE_PATH="/database-dumps/${TIMESTAMP}"
    MYSQLDUMP_OUTPUT_FILE_PATH+='-$DB_NAME.sql'
    MYSQLDUMP_NO_DATA_COMMAND+="$MYSQLDUMP_OUTPUT_FILE_PATH"
    MYSQLDUMP_COMMAND+="$MYSQLDUMP_OUTPUT_FILE_PATH"
    export UID
    docker-compose exec mysql bash -c "$MYSQLDUMP_NO_DATA_COMMAND && $MYSQLDUMP_COMMAND" || { echo "Failed to execute mysqldump commands in mysql container"; exit 1; }
  else
    MYSQLDUMP_OUTPUT_FILE_PATH="${PWD}/database-dumps/${TIMESTAMP}-detroitaxle-${WP_ENVIRONMENT}.sql"
    MYSQLDUMP_NO_DATA_COMMAND+="$MYSQLDUMP_OUTPUT_FILE_PATH"
    MYSQLDUMP_COMMAND+="$MYSQLDUMP_OUTPUT_FILE_PATH"
    bash -c "$MYSQLDUMP_NO_DATA_COMMAND && $MYSQLDUMP_COMMAND" || { echo "Failed to execute mysqldump commands"; exit 1; }
  fi
  echo "Database dumped to: ${MYSQLDUMP_OUTPUT_FILE_PATH}"
}

"$@"
