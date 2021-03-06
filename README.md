# ebook_classifier

A system that determines a books correct classification. This system can be trained to produced accurate results. It uses
Naive Bayes algorithm in determining the classification of a book.


# Dependencies

This application is using XPDF to extract meta data. So you need to have XPDF installed on your server or on your development environment. Please follow the instructions on the <a href="http://www.foolabs.com/xpdf/download.html">XPDF Website</a>.

Giving a quick start: On XPDFs website, you can just download the precompiled binaries depending on your platform and extract it to wherever you want or for best practice, put in a location not accessible via web. Instructions on how to use it in the application is found on the installation instructions below.


# Installation

1) Download the app <a href="https://github.com/ipabz/ebook_classifier/archive/master.zip">Ebook Classifier</a> and extract it
to your web accessible directory.

2) The app is using <a href="https://getcomposer.org/">Composer</a>. So you're computer needs have composer installed to download the other depencies the app needs. After you have composer installed execute the following

        composer install


3) On the extracted file, open

    /<extracted files>/application/config/database.php

and put the necessary settings username, password etc. to be able to connect to your database.

4) By the default on the file

    /<extracted files>/application/config/migration.php

Migration is already enabled:

    $config['migration_enabled'] = TRUE;

So, on your browser open

    http://localhost/<extracted file>/install

That will do the installation for your database creating the tables and fields needed. After that, you need to disable
migration to prevent anyone else to mess with your database.

You can do that on the file /<extracted files>/application/config/migration.php, setting $config['migration_enabled'] to false
as below:

    $config['migration_enabled'] = FALSE;

5) You need to set the config needed to use XPDF. To do that, open file

        appplication/libraries/string.php

and find the following variables

        //PDF Vars
        private $get_pdf_meta_data_cmd = 'C:\xampp\htdocs\xpdfbin-win-3.04\bin64\pdfinfo -f 1 -l 50 ';

Set it according to where your XPDF binaries are located.

6) We are using a Java library called PDFxStream, so you need to have java sdk installed and put it on

        appplication/libraries/string.php
        
and find  replace the following the the correct Java SDK path.

        private $javaBin = 'C:\Program Files\Java\jdk1.7.0_21\bin';



... and that's it. 
