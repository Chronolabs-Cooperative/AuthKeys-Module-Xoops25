## Chronolabs Cooperative presents

# AuthKeys for REST Services API v1.0.2

#### Written for implementation directly on xoops.org

### Author: Dr. Simon Antony Roberts <simon@snails.email>

This module allocates and allows for XOOPS Authentication keys too be generated for the REST Services API's on https://????.xoops.org

# Apache Module - URL Rewrite

The following script goes in your API_ROOT_PATH/.htaccess file

    php_value memory_limit 32M
    php_value error_reporting 0
    php_value display_errors 0
    php_value log_errors 0
    
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    
    RewriteRule ^([v0-9]{2})/(.*?)/([-?\d+]+)/([-?\d+]+)/([-?\d+]+)/(.*?)/(.*?)/(.*?).(gif|svg|png|jpg|html|unicode|binary)$ ./index.php?version=$1&data=$2&width=$3&height=$4&padding=$5&backcolour=$6&forecolour=$7&code=$8&output=$9 [L,NC,QSA]


To Turn on the module rewrite with apache run the following:

    $ sudo a2enmod rewrite
    $ sudo service apache2 restart
