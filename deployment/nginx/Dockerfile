ARG BUILD_ENV=prod

FROM nginx:1.21.6-alpine as build_common
COPY ./deployment/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./deployment/nginx/nginx.conf /etc/nginx/nginx.conf

FROM build_common as build_prod
ONBUILD RUN echo "Build for prod"
ONBUILD COPY ./public /app/public

FROM build_common as build_develop
ONBUILD RUN echo "Build for develop"

FROM build_${BUILD_ENV}
WORKDIR /app
