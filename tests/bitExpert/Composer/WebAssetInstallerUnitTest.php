<?php
namespace bitExpert\Composer;
require __DIR__ . '/../../../vendor/composer/composer/tests/Composer/Test/TestCase.php';


/**
 * Unit test for {@link \bitExpert\Composer\WebAssetInstaller}.
 *
 * @copyright bitExpert AG
 * @covers bitExpert\Composer\WebAssetInstaller
 */


class WebAssetInstallerUnitTest extends \Composer\Test\TestCase
{
	/**
	 * @var \org\bovigo\vfs\vfsStream\vfsStreamDirectory
	 */
	private $root;
	/**
	 * @var \bitExpert\Composer\WebAssetInstaller
	 */
	private $library;
	/**
	 * @var \Composer\Package\Package
	 */
	private $package;


	/**
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp()
	{
		$this->root = \org\bovigo\vfs\vfsStream::setup('project');

		$io = $this->getMock('\Composer\IO\IOInterface');
		$dm = $this->getMockBuilder('\Composer\Downloader\DownloadManager')
			->disableOriginalConstructor()
			->getMock();

		$config = new \Composer\Config();
		$config->merge(
			array(
				'config' => array(
					'vendor-dir' => \org\bovigo\vfs\vfsStream::url('vendor-dir'),
					'bin-dir'    => \org\bovigo\vfs\vfsStream::url('bindir')
				)
			)
		);

		$composer = new \Composer\Composer();
		$composer->setConfig($config);
		$composer->setDownloadManager($dm);

		$this->library = new WebAssetInstaller($io, $composer);

		$this->package = $this->getMockBuilder('\Composer\Package\Package')
			->setConstructorArgs(array(md5(rand()), '1.0.0.0', '1.0.0'))
			->getMock();
	}


	/**
	 * @test
	 * @covers bitExpert\Composer\WebAssetInstaller::supports
	 */
	public function installerSupportsPackagesOfTypeWebAsset()
	{
		$this->assertTrue($this->library->supports('webasset'));
	}


	/**
	 * @test
	 * @covers bitExpert\Composer\WebAssetInstaller::supports
	 */
	public function installerWillNotSupportNonWebAssetPackages()
	{
		$this->assertFalse($this->library->supports('library'));
		$this->assertFalse($this->library->supports('composer-installer'));
	}


	/**
	 * @test
	 * @covers bitExpert\Composer\WebAssetInstaller::getInstallPath
	 * @expectedException \InvalidArgumentException
	 */
	public function willThrowExceptionIfPackageHasNotDefinedTargetDirAsExtraParam()
	{
		$this->package->expects($this->never())
			->method('getTargetDir');

		$this->package->expects($this->once())
			->method('getExtra')
			->will($this->returnValue(array()));

		$this->library->getInstallPath($this->package);
	}


	/**
	 * @test
	 * @covers bitExpert\Composer\WebAssetInstaller::getInstallPath
	 */
	public function willReturnInstallPathForDefinedTargetDir()
	{
		$this->package->expects($this->never())
			->method('getTargetDir');

		$this->package->expects($this->once())
			->method('getExtra')
			->will($this->returnValue(array('target-dir'=> 'myVendor')));

		// will return webroot/myVendor
		$installPath = $this->library->getInstallPath($this->package);

		$this->assertStringEndsWith('myVendor', $installPath);
		$this->assertStringStartsWith('webroot', $installPath);
	}
}