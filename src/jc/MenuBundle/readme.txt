Allows to manage simple menu for front office.

To use menu inside template (app/Resources/views), you need to define current path to identify current selected menu :

    {% set currentPath = path(app.request.attributes.get('_route'), app.request.attributes.get('_route_params')) %}
    {{ render(controller("jcMenuBundle:MenuFO:display", {rootCurrentPath: currentPath, rootUri : app.request.uri})) }}
