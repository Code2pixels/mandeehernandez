FROM node:16
# Defaut node UID is 501
ARG UID=501
USER root
RUN usermod -u $UID node && \
    groupmod -g $UID node && \
    find / -ignore_readdir_race -group node -exec chgrp -h $UID {} \; && \
    find / -ignore_readdir_race -user node -exec chown -h $UID {} \;
USER node
