FROM node:16 as dev

RUN yarn global add @strapi/strapi --network-timeout 100000

RUN mkdir /app && chown 1000:1000 -R /app

WORKDIR /app

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["yarn", "develop"]

EXPOSE 1337


FROM dev as prod

ENV NODE_ENV=productionnn

COPY ./package.json ./yarn.lock ./

RUN yarn install

COPY . .

RUN yarn build

CMD ["yarn", "start"]
