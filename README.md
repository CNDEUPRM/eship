How to use: 
1. Clone the repository to your desired location.
2. Install composer to install the Symfony dependencies. You can download it here: https://getcomposer.org/
3. Once installed, go to the direction of the cloned project using the terminal
4. Run the command: composer install
5. This will install all of the dependencies of Symfony
6. Once finished, you can start the Symfony default virtual server by using the command: php app/console server:run

Database: 
1. The database was created using the ORM Doctrine and using MySQL as the DBMS
2. To create a new database, use the command: php app/console doctrine:database:create `database_name`
3. To delete a database use the command: php app/console doctrine:database:drop `database_name` --force
4. To create a new table, create a new Entity PHP class. You can see an example on the Entity Folder on the following path: src/Eship/EventBundle/Entity
5. To add any field to an existing Entity just add a new private function to the desired Entity Class, dont forget to use the ORM annotations as the
database will use this to specify the type of atribute it will be in the database. Also don't forget to generate the getters and setters of each function.
6. To update the database schema use the following command: php app/console doctrine:schema:update --force.
7. You can change the database connection by editing the parameters.yml file located in the app folder.

Routes: 
1. The routes file is located in: src/Eship/EventBundle/Resources/config, it has the name routing.yml
2. To add a new route, edit the file routing.yml. Use the same format as the one currently using.
3. The queries done in each route, will be located in the src/Eship/EventBundle/Controller Folder.
Example: defaults: { _controller: EventBundle:Default:homepage } means that the route is in the EventDundle Folder, Inside the Default Controller and its name is homepageAction. Every controller must have the controller name at the end of its name and every method that controls each route must have the word action at the end 
of its name. 
4. Each route will return the output of a query. In most cases the queries are being called from another file. These files are in the Repository Folders. Every route
will specifcy which repository they use.
5. You can also use annotations to create the routes of your API. I've created the annotations of each route for it to work, but I'm using the routing.yml instead,
I'm mainly using those annotations as a way to document each method or route. 

Symfony:
1. I recommend using the website https://knpuniversity.com/ to learn Symfony. It costs $24.99 a month but a month is all you need considering you can download each video.
2. The Symfony Documentation is also a great way to learn and its pretty easy to read.
3. In case of any doubt write me an email at francisco.morales2@upr.edu or francisco.morales.regionsurffa@gmail.com
4. Symfony can be intimidating at first but once you get the hang of it, its actually pretty easy to use. 


Symfony Standard Edition
========================

Welcome to the Symfony Standard Edition - a fully-functional Symfony
application that you can use as the skeleton for your new applications.

For details on how to download and get started with Symfony, see the
[Installation][1] chapter of the Symfony Documentation.

What's inside?
--------------

The Symfony Standard Edition is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev/test env) - Adds code generation
    capabilities

  * **DebugBundle** (in dev/test env) - Adds Debug and VarDumper component
    integration

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.

Enjoy!

[1]:  https://symfony.com/doc/2.8/setup.html
[6]:  https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
[7]:  https://symfony.com/doc/2.8/doctrine.html
[8]:  https://symfony.com/doc/2.8/templating.html
[9]:  https://symfony.com/doc/2.8/security.html
[10]: https://symfony.com/doc/2.8/email.html
[11]: https://symfony.com/doc/2.8/logging.html
[12]: https://symfony.com/doc/2.8/assetic/asset_management.html
[13]: https://symfony.com/doc/current/bundles/SensioGeneratorBundle/index.html
