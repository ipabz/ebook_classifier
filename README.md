# ebook_classifier

A system in its name determines a books correct classification. This system can be trained to produced accurate results. It uses
Naive Bayes algorithm in determining the classification of a book.

# Installation

1) Download the app <a href="https://github.com/ipabz/ebook_classifier/archive/master.zip">Ebook Classifier</a> and extract it
to your web accessible directory.

2) On the extracted file, open

    /<extracted files>/application/config/database.php
    
and put the necessary settings username, password etc. to be able to connect to your database.

3) By the default on the file

    /<extracted files>/application/config/migration.php
    
Migration is already enabled:

    $config['migration_enabled'] = TRUE;
    
So, on your browser open 

    http://localhost/<extracted file>/install
    
That will do the installation for your database creating the tables and fields needed. After that, you need to disable
to prevent anyone else to mess with your database.

You can do that on the file /<extracted files>/application/config/migration.php, setting $config['migration_enabled'] to false
as below:

    $config['migration_enabled'] = FALSE;


... and that's it. The system is ready.

Simple :-D
