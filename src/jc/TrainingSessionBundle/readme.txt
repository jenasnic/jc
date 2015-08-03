Allows to manage training session with contact, location and comments.

1/ Add CSS (in 'Resources/public/css' directory) in website's resources ('/web/resources/css') => CSS for back office

2/ Add scripts (in 'Resources/public/js' directory) in website's resources ('/web/resources/js')
NOTE : script 'trainingSession.js' for front office and script 'trainingSessionLocation.js' for back office

This bundle requires UserBundle to work (need User for comment...) and ToolBundle (for pagination).

It also requires database 'contact', 'location', 'trainingSession' and 'trainingSessionComment' (see SQL in 'Resources/public/database' directory).
