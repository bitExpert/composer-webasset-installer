README
======

What is the Webasset Installer?
----------------

The WebAsset Installer is a custom installer for Composer. To read more about
custom Installers in Composer feel free to read the documentation:
http://getcomposer.org/doc/articles/custom-installers.md

Wrap-up: The WebAsset installer will install Composer packages with the type of
"webasset" in an webroot folder not in the vendor directory.

How to use it?


The composer.json of your webassets package needs to look like this: The package
needs to be of type "webasset" and needs to define a target-dir in the extra`s
configuration. The target-dir defines the relative path beneath the webroot
folder where the webassets get installed.

	{
		"name": "vendor/mywebpackage",
		"type": "webasset",
		"require": {
			"bitexpert/web-asset-installer": "*"
		},
		"extra": {
			"target-dir": "mywebpackage/"
		}
	}

The composer.json of your root project looks like this:

	{
		"name": "my/mywebproject",
		"require": {
			"vendor/mywebpackage": "*"
		}
	}

To change the base folder in which the webassets get installed simply add the
"webasset-basedir" extra param to your root package composer.json file:

	{
		"name": "my/mywebproject",
		"require": {
			"vendor/mywebpackage": "*"
		},
		"extra": {
			"webasset-basedir": "htdocs/"
		}
	}
