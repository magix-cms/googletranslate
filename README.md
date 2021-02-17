# Google Translate
Plugin Google Translate V3 for [magixcms 3](https://www.magix-cms.com)

![Google Translate](https://user-images.githubusercontent.com/356674/108212704-7f1d6800-712e-11eb-900b-ac5ea43f4bc8.png)

### version 

[![release](https://img.shields.io/github/release/magix-cms/googletranslate.svg)](https://github.com/magix-cms/googletranslate/releases/latest)

Authors
-------

* Gerits Aurelien (aurelien[at]magix-cms[point]com)

## Description
Connexion à l'API Google Translate officielle pour vous permettre de développer vos propres outils

## Installation
 * Décompresser l'archive dans le dossier "plugins" de magix cms
 * Connectez-vous dans l'administration de votre site internet
 * Cliquer sur l'onglet plugins du menu déroulant pour sélectionner Google Translate.
 * Une fois dans le plugin, laisser faire l'auto installation
 * Il ne reste que la configuration du plugin pour correspondre avec vos données.

Requirements
   ------------
   * CURL (http://php.net/manual/en/book.curl.php)
   
### Exemple d'utilisation dans vos plugins

```php
$googletranslate = new plugins_googletranslate_admin();
    $translate = array(
    'q' =>  array(
        "hello the world",
        "my website"
     ),
    'source'=>"en",
    'target'=>"fr"
    );

    $setTranslateApi = $googletranslate->getTranslateText($translate);
````
Ressources
 -----
  * https://github.com/googleapis/google-cloud-php-translate
  * https://www.magix-cms.com
