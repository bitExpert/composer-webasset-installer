<?php
/*
 * This file is part of the Web Asset Installer Plugin.
*
* (c) bitExpert AG
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace bitExpert\Composer;
use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Package\Package;


/**
 * Plugin to register the installer with Composer
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Stephan Hochdörfer
 */


class WebAssetInstallerPlugin implements PluginInterface
{
	/**
	 * @see \Composer\Plugin\PluginInterface::activate
	 */
	public function activate(Composer $composer, IOInterface $io)
	{
		$baseDir = 'webroot/';
		$package = $composer->getPackage();
		if($package instanceof Package)
		{
			$extra = $package->getExtra();
			if(isset($extra['webasset-basedir']))
			{
				$baseDir = $extra['webasset-basedir'];
			}
		}

		$installer = new WebAssetInstaller($io, $composer, $baseDir);
		$composer->getInstallationManager()->addInstaller($installer);
	}
}