Allows to define skin for website.

This bundle require database 'skin' (see SQL in 'Resources/public/database' directory).

All skins are defined with one CSS file in back-office.

You can choose in back office which skin must be applied.

To use skin in front office, update template using skin by adding following line in header :
    {{ render(controller("BoduSkinBundle:SkinFO:display")) }}

NOTE : Base path containg CSS files is '/web/resources/css/skins'. You can change this path in 'Form/SkinType.php' file (SKIN_FOLDER_PATH).
