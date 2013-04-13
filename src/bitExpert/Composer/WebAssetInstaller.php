<?php
namespace bitExpert\Composer;
use Composer\Package\PackageInterface;


/**
 * Custom Installer for web assets (e.g. Javascript or CSS files). Will install
 * the package in the webroot folder not in the (default) vendor directory making
 * the files publicly accessible.
 *
 * @copyright bitExpert AG
 * @author Stephan Hochdörfer
 */


class WebAssetInstaller extends \Composer\Installer\LibraryInstaller
{
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
	 * @see Composer\Installer\LibraryInstaller::supports
	 */
	public function supports($packageType)
	{
		return (bool) ('webasset' === $packageType);
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