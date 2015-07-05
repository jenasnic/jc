Bundle to resolve alchemy effect in Skyrim (in development): 

    - effects linked to specific ingredient
    - ingredients linked to specific effect
    - ingredients whith common effects to realize potion

This bundle requires database 'ingredient', 'effect' and 'ingredient_effect' (see SQL in 'Resources/public/database' directory).
WARNING : You need to add datas in database (see 'data.sql')

NOTE 1 : Add script 'Resources/public/js/skyrim.js' in website's resources ('/web/resources/js').
NOTE 2 : Add CSS 'Resources/public/css/skyrim.css' in website's resources ('/web/resources/css').

IMPORTANT : this bundle contains additional Twig function to search if ingredient contains specific effect.
This function is useful to determine common effects between two ingredients.