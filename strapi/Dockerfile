FROM node:16 as dev

RUN yarn global add @strapi/strapi

RUN mkdir /srv/app && chown 1000:1000 -R /srv/app

WORKDIR /srv/app

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["yarn", "develop"]

EXPOSE 1337


FROM dev as prod

ENV NODE_ENV=productionnn

COPY ./app/package.json ./app/yarn.lock ./

# RUN yarn install

COPY ./app ./

# RUN yarn build

CMD ["yarn", "start"]
