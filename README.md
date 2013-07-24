PHP-APP

This app is working with both [CodeIgniter 2](http://ellislab.com/codeigniter) and [Doctrine 2](http://www.doctrine-project.org/).

Models are contained in `application/models/Entity`

### Dev Mode
Dev mode is disabled by default, but you can enable it by setting `$dev_mode = true;` in `application/libraries/Doctrine.php`. This will auto-generate proxies and use a non-persistent cache (`ArrayCache`). Remember to turn dev mode off for production!

### Set up

* Download the archive and extract it to the folder you want.
* Go to `your_folder/application`.
* Edit the file `config/database.php` with the right credentials.
* Run `./doctrine orm:schema-tool:create`, that will automatically create your tables in the database you set up before in your `config/database.php` file.
* Launch the Crawler.rb (ie: `ruby Crawler.rb http://www.tripadvisor.fr/Hotels-g187147-Paris_Ile_de_France-Hotels.html`
