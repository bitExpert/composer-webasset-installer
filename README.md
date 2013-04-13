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
	{
		"name": "vendor/MyWebPackage",
		"type": "webasset",
		"require": {
			"bitExpert/WebAssetInstaller": "*"
		}
	}
