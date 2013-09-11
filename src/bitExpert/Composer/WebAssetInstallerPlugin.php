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
	public function activate(Composer $composer, IOInterface $io)
	{
		$installer = new WebAssetInstaller($io, $composer);
		$composer->getInstallationManager()->addInstaller($installer);
	}
}