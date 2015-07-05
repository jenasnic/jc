Allows to define static text for website (text to display on page).

This bundle requires database 'staticText' (see SQL in 'Resources/public/database' directory).

All static text must define a unique code that is used when displaying it in page from front office.

To display a text on front office, add following line in page :
    {{ render(controller("jcStaticTextBundle:StaticTextFO:display", {'code': 'XXX' })) }}

NOTE : Static text are added in div with CSS class 'static-text-content' to ovveride style if needed.
