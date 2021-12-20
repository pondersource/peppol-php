#client-3 & server-3
usage:

define server url in config.php (defaults to localhost:8080)
change base-example.xml to include the data you want to have in the invoice
run with php -S localhost:12321
visit localhost:12321 to send xml to server and receive html of invoice, or, in case base-example.xml has been changed in a way that's not in accordance with the spec, an error message.