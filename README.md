# Joomla 4x Example Plugin - CLI code to Publish or Unpublish a module

This plugin is intended to set the published state of a module depending on the date.

## Prerequisites

Joomla 4. It will not work on earlier Joomla versions.

## Installing

Create a zip file from the the j4xdemos-plg-onoffbydate folder and install it in Joomla 4.
After installation it needs to be enabled.

Use the code with command line calls:

php cli/joomla.php onoffbydate:action --help 

php cli/joomla.php onoffbydate:action winter 130

Making sure to use the correct php path - the command line version my be different
from the web version.

### Documentation

A tutorial explantion of what this plugin does and how it works is availablae at https://docs.joomla.org/J4_CLI_example_-_Onoffbydate. Also, read the code of the Cli class.

## Author

* **Clifford E Ford**

## License

This project is licensed under the [GPL3 License](http://www.gnu.org/licenses/gpl-3.0.html)

## Acknowledgments

* The Joomla 4 Project Team
* This Joomla 4 [Tutorial](https://docs.joomla.org/J4.x:Writing_A_CLI_Application)
