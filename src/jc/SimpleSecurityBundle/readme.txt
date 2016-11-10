Use this bundle for simple connexion without database user.

1/ Add following lines in 'app/config/routing.yml' :
    login_check:
        path: /login_check
    logout:
        path: /logout


1/ Define security in 'app/config/security.yml' (default password is 'admin') :

    encoders:
        Symfony\Component\Security\Core\User\User: sha512

    role_hierarchy:
        ROLE_ADMIN: ROLE_ADMIN

    providers:
        admin_provider:
            memory:
                users:
                    # Default password is 'admin' (change hash for security)
                    admin: { password: nhDr7OyKlXQju+Ge/WKGrPQ9lPBSUFfpK+B1xqx/+8zLZqRNX0+5G1zBQklXUFy86lCpkAofsExlXiorUcKSNQ==, roles: [ 'ROLE_ADMIN' ] }

2/ Update firewall section (in 'app/config/security.yml') for resources access (CSS, JS, pictures...) => add 'resources' entry with no security

        resources:
            pattern:  ^/resources
            security: false

3/ Update 'main' entry in firewall section (in 'app/config/security.yml') => to take into account login and logout
NOTE 1 : You can define logout callback URL (main > logout > target)
NOTE 2 : Set parameter 'invalidate_dession' to false to avoid bug (logout, using flash bag session with redirect...)

        main:
            pattern:  ^/
            anonymous: true
            provider: admin_provider
            form_login:
                login_path: login
                check_path: login_check
            logout:
                path: logout
                target: /
                invalidate_session: false

4/ Add 'access_control' entry (in 'app/config/security.yml') to define security scheme

    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }

NOTE 1 : To logout => use path 'logout' (ex : <a href="{{ path('logout') }}">Déconnexion</a>)

NOTE 2 : Full sample for 'app/config/security.yml' :

security:
    encoders:
        Symfony\Component\Security\Core\User\User: sha512

    role_hierarchy:
        ROLE_ADMIN: ROLE_ADMIN

    providers:
        admin_provider:
            memory:
                users:
                    admin: { password: nhDr7OyKlXQju+Ge/WKGrPQ9lPBSUFfpK+B1xqx/+8zLZqRNX0+5G1zBQklXUFy86lCpkAofsExlXiorUcKSNQ==, roles: [ 'ROLE_ADMIN' ] }
    firewalls:
        dev:
            pattern:  ^/(_(profiler|wdt)|css|images|js)/
            security: false
        resources:
            pattern:  ^/resources
            security: false
        main:
            pattern:  ^/
            anonymous: true
            provider: admin_provider
            form_login:
                login_path: login
                check_path: login_check
            logout:
                path: logout
                target: /
                invalidate_session: false

    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
