FROM nginx
COPY certs/ssl-bundle.crt /etc/nginx/certs/ssl-bundle.crt
COPY certs/private.key /etc/nginx/certs/private.key
COPY sites-enabled/counter_vhost /etc/nginx/conf.d/counter_vhost
EXPOSE 80 443 6739
