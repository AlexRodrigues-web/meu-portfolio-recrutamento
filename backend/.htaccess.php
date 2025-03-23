RewriteEngine On
RewriteBase /backend/

# Rota para o index.php (ponto de entrada da API)
RewriteRule ^$ index.php [L]

# Redireciona para as rotas da API
RewriteRule ^api/?$ routes/api.php [QSA,L]
RewriteRule ^api/(.*)$ routes/api.php?action=$1 [QSA,L]

# Redirecionamento global (mantido para futuras necessidades)
RewriteRule ^(.*)$ /meu-portfolio-recrutamento/$1 [L]

<IfModule mod_headers.c>
    Header set Access-Control-Allow-Origin "*"
    Header set Access-Control-Allow-Methods "POST, GET, OPTIONS"
    Header set Access-Control-Allow-Headers "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"
</IfModule>
