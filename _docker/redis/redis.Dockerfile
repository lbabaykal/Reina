FROM redis:7.4.1

# Копируем конфигурационный файл Redis
COPY ./_docker/redis/redis.conf /usr/local/etc/redis/redis.conf
# Копируем файл ACL
COPY ./_docker/redis/users.acl /usr/local/etc/redis/users.acl
# Запуск Redis с использованием конфигурационного файла
CMD ["redis-server", "/usr/local/etc/redis/redis.conf"]
