#stage 1
FROM node:latest as node
WORKDIR /ng
COPY . .
RUN npm install
RUN npm update
RUN npm run build
#stage 2
FROM nginx:alpine
COPY --from=node /ng/dist/ng /usr/share/nginx/html
