Simple slideshow based on directory on FTP.

This bundle requires both database 'slideshow' and 'picture' (see SQL in 'Resources/public/database' directory).

It allows to store pictures on FTP in folders and each folder can be read as a slideshow with pictures it contains.
WARNING : Only one directory level is managed (sub directories are not taken into account)

NOTE 1 : Base path to store folder and pictures on FTP can be set in config file 'Resources/config/services.yml' (default value is '/userfiles/ftpSlideshow').

NOTE 2 : Add scripts (in 'Resources/public/js' directory) in website's resources ('/web/resources/js') and include this script to load slideshow using ajax.
