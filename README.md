[![Latest Release](https://img.shields.io/github/v/release/Jefferson49/Joomla_plugin_sexypolling_reloaded?display_name=tag)](https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded/releases/latest)
[![Joomla major version](https://img.shields.io/badge/joomla-v3.x-green)](https://downloads.joomla.org/cms/joomla3)
[![Joomla major version](https://img.shields.io/badge/joomla-v4.x-green)](https://downloads.joomla.org/cms/joomla4)
## Sexy Polling Reloaded: A Joomla 4.x migration (and Joomla 3.x update) for the [Joomla](https://www.joomla.org/) extension "Sexy Polling" 
+ "Sexy Polling Reloaded" is a fork of the "Sexy Polling" extension (version 2.1.7), which was developed by 2GLux.com and provided on the former website [2GLux.com](https://web.archive.org/web/20211215150923/https://2glux.com/projects/sexypolling)
+ The fork intends to make the functionality of the former "Sexy Polling" extension available for Joomla 4, because the original extension is not provided and supported any more
+ A patch was added to fix a reported [security issue](https://www.exploit-db.com/exploits/50927)
+ Some limitations of the former FREE version were removed
+ Support for the Joomla update system was added to check and install new releases of the extension
+ **The code was migrated to the Joomla 4.x CMS and module API, while still keeping it usable for Joomla 3.10**
+ The latest release can be used for both Joomla 4.x and Joomla 3.10

##  Installation
+ Manual installation
    + Go to the [release page](https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded/releases) and download the latest release
    + Install the ZIP package in the Joomla administration backend
+ Joomla update system
    + Prerequesite: first installation has to be installed manually, see above
    + Joomla will automatically check for updates in the administration backend
    + If an update is available, change to the Extensions / Update menu and install the update 
+ **PHP extension intl required**
   + The extension requires the PHP exension "intl" (Internationalization). Usually, the "intl" extension is included in the PHP installation. However, it might be necessary to activate it, i.e. the php.ini file must contain the following line: extension=intl
   + If the "intl" extension is not installed, PHP errors like "Class IntlTimeZone not found", or "Attempted to load class IntlTimeZone from the global namespace" might occur.
+ **MySQL version**
   + Extension releases starting from **v4.1.7** need a MySQL version of 5.7.24 (8.0.13) or later.
   + For MySQL versions earlier than 5.7.24, the former extension release v4.1.6 can be used. 
+ **Migration from the former "Sexy Polling" extension**
    + During installation, the extension re-uses existing data from the former Sexy Polling extension. 
    + If you want to reuse data from the former Sexy Polling extension, do not uninstall the former Sexy Polling extension. Instead, just install the Sexy Polling Reloaded extension. It will re-use the existing database tables.
+ **Known issues**
    + If the extension installation fails with an error "**... column 'country' can't have a default value**", an incompatibility with the database version (earlier than 5.7.24/8.0.13) or database configuration exists. In this case, it is recommended to use the former extension release **v4.1.6**. 
##  Date formats
The date format, which is shown in poll modules, can be specified in the Joomla administration at: Components -> Sexy Polling Reloaded -> Polls -> Edit -> Date Format.

Examples for the date format: 
+ d/m/Y (22-11-2022)
+ m/d/Y (11-22-2012)
+ M d, Y (Nov 22, 2022)
+ F d, Y (November 22, 2022)

For more details about the format options, [see PHP documentation about date time format](https://www.php.net/manual/en/datetime.format.php).

## Development and Contributions
+ The extension was developed by [2GLux.com](2GLux.com) for Joomla 2.5 and 3 with the original extension name "Sexy Polling".
+ After the "Sexy Polling" extension was removed from the web and the support was not continued, a fork of the extension was migrated to Joomla 4 with the new extension name "Sexy Polling Reloaded" by [Jefferson49](https://github.com/Jefferson49)
+ Further contributions on [Github](https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded) are welcome!

##  Versions 
+ The latest extension version was developed and tested with: 
    + [Joomla 3.10.11](https://downloads.joomla.org/cms/joomla3) and [Joomla 4.2.6](https://downloads.joomla.org/cms/joomla4); but should also run with other Joomla 3.10 or 4.x versions. Other 3.x versions have not been tested, but might also be feasible.
    + PHP 8.0.23 as well as PHP 8.1.13; but should also run with other PHP 8 versions. 7.x versions have not been testetd, but might also be feasible.

## Translation
You can help to translate this module:
+ User frontend translations: [/com_sexypolling/site/language](https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded/tree/joomla_4.x/com_sexypolling/site/language)
+ Administrator backtend translations: [/com_sexypolling/admin/language](https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded/tree/joomla_4.x/com_sexypolling/admin/language)  

You can use a text editor like notepad++ to work on translations.

You can contribute translations via a pull request (if you know how to do), or by opening a new Github issue and attaching the file. Updated translations will be included in the next release of this module.

Currently, the following frontend languages are available:
+ Dutch
+ English
+ Farsi
+ French
+ German
+ Greek
+ Italian
+ Russian
+ Slovenian
+ Spanish
+ Turkish

## Issue reporting
If you experience any bugs [create a new issue](https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded/issues) in the Github repository
##  Github repository  
https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
