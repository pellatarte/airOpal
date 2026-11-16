# =====================================================================
# L'image du service web : Apache + PHP 8.3, avec tout ce dont AirOpale
# a besoin jusqu'à la fin du module.
#
# Vous n'avez pas à modifier ce fichier.
# =====================================================================
FROM php:8.3-apache

# --- Extensions PHP ---------------------------------------------------
#   pdo_mysql : Doctrine parle à MySQL par PDO
#   intl, zip : exigées par Symfony
#   opcache   : comportement réaliste d'un serveur
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libicu-dev \
        libzip-dev \
        unzip \
        git \
    && docker-php-ext-install pdo_mysql intl zip opcache \
    && rm -rf /var/lib/apt/lists/*

# --- Réécriture d'URL : indispensable au front controller de Symfony ---
RUN a2enmod rewrite

# --- LA racine web : public/, et rien d'autre -------------------------
# src/, config/, .env, vendor/ sont montés À CÔTÉ : lisibles par PHP,
# injoignables depuis un navigateur.
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Autoriser le .htaccess de public/ (celui de Symfony).
RUN { \
        echo '<Directory ${APACHE_DOCUMENT_ROOT}>'; \
        echo '    AllowOverride All'; \
        echo '</Directory>'; \
    } > /etc/apache2/conf-available/airopale.conf \
    && a2enconf airopale

# --- Erreurs visibles : c'est un environnement de développement -------
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# --- L'heure de Paris -------------------------------------------------
# Sans ces deux lignes, PHP compte en UTC : un relevé fait à 10 h
# s'afficherait « 09:00 ». Les relevés sont datés : on règle ça d'entrée.
ENV TZ=Europe/Paris
RUN echo 'date.timezone = Europe/Paris' > "$PHP_INI_DIR/conf.d/fuseau.ini"

# --- Composer ---------------------------------------------------------
# vendor/ est livré dans l'archive : vous n'en aurez pas besoin en séance.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
