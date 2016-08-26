# My_Website
THIS IS A WORK IN PROGRESS

This is a website built in PHP using WAMP MYSQL, using the bootstrap library to maintain functionality over different devices.

------Screenshots------
INDEX
![Alt text](https://github.com/bamsargeant/My_Website/tree/master/public/uploads/index_ss.png?raw=true "Index.php")

BLOG
![Alt text](https://github.com/bamsargeant/My_Website/tree/master/public/uploads/blog_ss.png?raw=true "Index.php")

ADMIN
![Alt text](https://github.com/bamsargeant/My_Website/tree/master/public/uploads/admin_ss.png?raw=true "Index.php")

EDIT_POST
![Alt text](https://github.com/bamsargeant/My_Website/tree/master/public/uploads/edit_ss.png?raw=true "Index.php")

------PUBLIC-------

INDEX.php     - The homepage will display the logo, as well as the most recent blog and project posts.

BLOG.php      - The blog page will grab an article from the blog table, which contains a title, an image path, date and content.

PROJECTS.php  - The blog page will grab an article from the blog table, which contains a title, an image path, date and content.

RESUME.php - A page to display my resume

LOGIN.php - A login page to access the admin section.

ADMIN.php - Edit or create a new article. Contains a form which will be populated with the chosen article.

NEW_ARTICLE.php - No html. This page will simply process the form to create a new entry into the table.

EDIT_ARTICLE.php - No html. This page will simply process the form to edit the article.

------INCLUDES------

FUNCTIONS.php - This page will hold all the functions for database lookup.

DB_CONNECTION.php - This page will connect to the sql database.

SESSION.php - This page will get the session details to maintain login between pages.

VALIDATION_FUNCTIONS.php - This page will check for errors on the form page.

HEADER.php - Provide a page that holds the nav-bar.

FOOTER.php - Provide a page that holds the footer, and closes the database connection.
