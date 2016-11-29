Use this bundle to manage connexion with users + roles from database.

It allows user to manage its own account and to ask new password if needed (forgotten password).

WARNING 1 : This bundle depends on ToolBundle.

1/ Add following lines in 'app/config/routing.yml' :
    login_check:
        path: /login_check
    logout:
        path: /logout


2/ Configure mail parameters in 'Resources/config/services.yml'
    prefix_mail: JC
    from_mail: jc@aequum.fr
    from_name: JC

NOTE : Prefix mail is optionnal (can be empty). It is used in mail's subject : '[prefix] - subject'


3/ Define security in 'app/config/security.yml' :

    encoders:
        Symfony\Component\Security\Core\User\User: sha512
        jc\UserBundle\Entity\User: sha512

    role_hierarchy:
        ROLE_ADMIN: ROLE_USER

    providers:
        user_service:
            entity: { class: jc\UserBundle\Entity\User, property: username }

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
            provider: user_service
            form_login:
                login_path: login
                check_path: login_check
            logout:
                path: logout
                target: /
                invalidate_session: false

    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/user, roles: ROLE_USER }
