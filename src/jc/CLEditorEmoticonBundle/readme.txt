Plugin for CLEditor => add icon in task bar to display emoticons in WYSIWYG.

1/ Add folder 'emoticons' (contains all pictures for smileys) in '/web/resources/images' directory

2/ Add script '/js/plugin.cleditor.emoticon.js' in '/resources/scripts' directory (script to include when using CLEditor)

3/ Update CSS with content of file 'css/style.css' (optionnal) 

4/ Add picture 'css/images/smiley.png' in '/resources/css/images' directory

5/ Initialize CLEditor with control 'emoticon' : $('#wysiwyg').cleditor({controls: "emoticon"});
