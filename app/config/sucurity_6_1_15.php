security:
    encoders:
        Bundle\AdminBundle\Entity\KidsKulaUsers:
            algorithm: sha512

    role_hierarchy:
#        ROLE_EMPLOYEE:    [ROLE_ADVOCATES]
#        ROLE_RECRUITERS:  [ROLE_EMPLOYER]
        ROLE_SUPER_ADMIN: [ROLE_ADMIN,ROLE_PARENT,ROLE_STUDENT]
        
    providers:
        fos_userbundle:
            id: fos_user.user_provider.username_email
    firewalls:
        main:
            pattern:  ^/
            anonymous: ~
            form_login: 
                login_path: /student/login
                provider: fos_userbundle
                csrf_provider: form.csrf_provider
                check_path:    fos_user_security_check
                
               
            logout:
                path:   /logout
                target: /student/login
                #success_handler: security.logout.success_handler
            remember_me: 
                key:      "%secret%"
                lifetime: 31536000 # 365 days in seconds
                path:     /
                domain:   ~ # Defaults to the current domain from $_SERVER    

    access_control:
        - { path: /admin/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: /student, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: /student/find-friends, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: /student/search_friends, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: /student/contact, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: /student/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: /student/forgotpassword, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: /reset-password, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: /student/registration, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: /student/auth_registration/, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: /student_activation , roles: IS_AUTHENTICATED_ANONYMOUSLY}
        - { path: /parent, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/student, roles: ROLE_STUDENT }
        - { path: ^/parent, roles: ROLE_PARENT }
        