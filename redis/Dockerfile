FROM redis:latest
RUN apt-get update && apt-get install -y pwgen
ADD run.sh /run.sh
COPY conf/redis.conf /usr/local/etc/redis/redis.conf
CMD ["/run.sh"]
