Base elements when creating new Symfony project (new website).

1/ Add folder 'resources' (contains all CSS, JS images requireed for new website) in '/web' directory

2/ Add folder 'template/TwigBundle' in '/app/Resources' directory (contains default page error)

3/ Add folder 'template/views' in '/app/Resources' directory (contains template for theming)

4/ Update Twig Configuration in file '/app/config/config.yml' (add resource 'custom_errors' for theming form) :

    # Twig Configuration
    twig:
        debug:            "%kernel.debug%"
        strict_variables: "%kernel.debug%"
        form:
            resources:
                - ':forms:custom_errors.html.twig'
