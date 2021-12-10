FROM tiangolo/nginx-rtmp
COPY ./nginx.conf /etc/nginx/nginx.conf
RUN mkdir -p /var/hls/live-stream
EXPOSE 1935
EXPOSE 1936
