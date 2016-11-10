Allows to manage simple menu for front office.

1/ Add CSS (in 'Resources/public/css' directory) in website's resources ('/web/resources/css')
NOTE : Update this CSS to match with design from front office.

2/ Add scripts (in 'Resources/public/js' directory) in website's resources ('/web/resources/js')

3/ To use menu inside template (app/Resources/views), you need to define current path to identify current selected menu :

    {% set currentPath = path(app.request.attributes.get('_route'), app.request.attributes.get('_route_params')) %}
    {{ render(controller("jcMenuBundle:MenuFO:display", {rootCurrentPath: currentPath, rootUri : app.request.uri})) }}
