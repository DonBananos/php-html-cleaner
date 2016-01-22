# PHP HTML Cleaner
A small PHP project for making an HTML cleaner, for securing user input.

## How does it work?
- Place the html_cleaner.php file somewhere in your project
- Create an Html_cleaner object
- call function Html_cleaner->start_cleaning
- the response is the cleaned string
- NB: If you want to use your own whitelist, create an array with accepted tags (both start and end, e.g.: `<p></p><br/>`)
 
```
  $whitelist = NULL;
  $cleaner = new Html_cleaner();
  $response = $cleaner->start_cleaning($_POST['text'], $whitelist, TRUE);
```

For a demo, use the index.php file.
This will also show how you can use the cleaner

*PHP HTML Cleaner is licensed under the MIT license*
