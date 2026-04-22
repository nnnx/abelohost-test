DC=docker compose
MYSQL_SERVICE=mysql
DB_NAME=abelohost_test
DB_USER=root
DB_PASS=123123

# -----------------------
# DUMP DATABASE
# -----------------------

db-dump:
	$(DC) exec $(MYSQL_SERVICE) mysqldump -u $(DB_USER) -p$(DB_PASS) $(DB_NAME) > ./.docker/mysql/dump.sql

# -----------------------
# RESTORE DATABASE
# -----------------------

db-restore:
	$(DC) exec -T $(MYSQL_SERVICE) mysql -u $(DB_USER) -p$(DB_PASS) $(DB_NAME) < ./.docker/mysql/dump.sql