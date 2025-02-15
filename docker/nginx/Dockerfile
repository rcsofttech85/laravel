FROM nginx:latest AS prod
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

FROM prod AS dev