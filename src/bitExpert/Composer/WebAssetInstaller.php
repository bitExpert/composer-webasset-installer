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
use Composer\Package\PackageInterface;
use Composer\Composer;
use Composer\IO\IOInterface;


/**
 * Custom Installer for web assets (e.g. Javascript or CSS files). Will install
 * the package in the webroot folder not in the (default) vendor directory making
 * the files publicly accessible.
 *
 * @author Stephan Hochdörfer
 */


class WebAssetInstaller extends \Composer\Installer\LibraryInstaller
{
	/**
	 * Creates a new {@link \bitExpert\Composer\WebAssetInstaller}.
	 *
	 * @param IOInterface $io
	 * @param Composer $composer
	 */
	public function __construct(IOInterface $io, Composer $composer)
	{
		parent::__construct($io, $composer, 'webasset');
	}


	/**
	 * @see Composer\Installer\LibraryInstaller::getInstallPath
	 */
	public function getInstallPath(PackageInterface $package)
	{
		$extra = $package->getExtra();

		if(!isset($extra['target-dir'])) {
			throw new \InvalidArgumentException(
				'Unable to install web asset. Missing target-dir parameter in extra field.'
			);
		}

		return $this->getRootPath() . '/' . $extra['target-dir'];
	}


	/**
	 * Returns the relative root path where to install the web assets.
	 *
	 * @return string
	 */
	protected function getRootPath()
	{
		return 'webroot';
	}
}