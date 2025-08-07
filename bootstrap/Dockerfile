# ベースイメージの指定
FROM php:8.1-fpm

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 作業ディレクトリの設定
WORKDIR /var/www

# 現在のディレクトリのファイルをコンテナ内にコピー
COPY . .

# 依存関係のインストール
RUN composer install --no-dev --optimize-autoloader

# パーミッションを設定（必要に応じて）
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# サーバーの起動
CMD ["php-fpm"]

# ポートの公開
EXPOSE 9000
