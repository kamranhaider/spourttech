# Spourt Teck Test Project

Root Files: index.php, ajax.php

Classes : classes/cart.php

Database backup: database.sql

Styling: All styling and front end scripts are in assets folder.

## Methods
cart->dbConnect: This is private method that connects to the database and return a connection resource object.

cart->dbClose: This method closes the database connection.

cart->createSession: Method to initialize the new cart in cookies as well as in the database.

cart->randomString : Generate a 16 characters random string for session id.

cart->getCart : This method gets current items in the existing cart, calculates the discounts and delivery charges and returns the pre-compiled data along with products list in the cart

cart->addToCart : Adds product in the cart.

cart->getProducts : Returns the list of products.

cart->checkOut : Checkout and closes the cart, and initialize a new cart.
