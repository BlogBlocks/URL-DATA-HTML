# URL-DATA-HTML
This set of files captures a URL converts it to 64_base stores it in an SQL database. Then convert the data to an html webpage with the name of your choice. This does not capture the CSS. It was made to be used to capture MySQL queries from the  same site so it uses the css referenced in the header. It will of course capture inline CSS fine.


The newly added index.php is a all in one file. It works and is being used on my site. I incleded a delete feature to delete entries in the database.

Files capture well with css if the css link is complete and not relative.

CSS effects the index.php file as it inherits much of the css. That was the reason I added the delete feature. Once the static HTML file is created there is no need to keep the files in the database.
