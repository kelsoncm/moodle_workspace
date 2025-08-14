############################
## Imagem base
####################################################################################
FROM php:8.3.24-apache-bookworm

ENV DEBIAN_FRONTEND=noninteractive
ENV MOODLE_VERSION=4.5.6

ADD build/php-extensions.sh             /tmp/build/php-extensions.sh
ADD build/locale.gen                    /etc/locale.gen
ADD src/ini/                            /usr/local/etc/php/conf.d/
ADD src/shell/                          /usr/local/bin/


RUN    /tmp/build/php-extensions.sh \
    && chmod 777 /tmp \
    && chmod +t /tmp \
    \
    && curl -L https://github.com/moodle/moodle/archive/refs/tags/v$MOODLE_VERSION.tar.gz | tar -zx --strip-components=1 \
    && mkdir /var/www/moodledata \
    && chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www \
    && mkdir -p /var/log/moodle    && chown -R www-data:www-data /var/log/moodle \
    && mkdir -p /var/log/apache2   && chown -R www-data:www-data /var/log/apache2 \
    && mkdir -p /var/log/cron      && chown -R www-data:www-data /var/log/cron


ADD --chown=www-data:www-data src/php/ /var/www/html/

ADD build/moodle-install-package.sh     /tmp/build/moodle-install-package.sh
ADD build/plugins                 /tmp/build/plugins
USER www-data
WORKDIR /tmp/build/plugins
RUN for plugin in *.zip ; do /tmp/build/moodle-install-package.sh $plugin; done

USER www-data
WORKDIR /var/www/html
EXPOSE 80
ENTRYPOINT ["docker-php-entrypoint"]
CMD ["apache2-foreground"]
