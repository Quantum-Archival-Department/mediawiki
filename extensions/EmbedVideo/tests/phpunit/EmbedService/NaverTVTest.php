<?php

declare( strict_types=1 );

namespace MediaWiki\Extension\EmbedVideo\Tests\EmbedService;

use InvalidArgumentException;
use MediaWiki\Extension\EmbedVideo\EmbedService\NaverTV;
use MediaWikiIntegrationTestCase;

/**
 * @group EmbedVideo
 */
class NaverTVTest extends MediaWikiIntegrationTestCase {

	/**
	 * A valid ID
	 * @var string
	 */
	private string $validId = '27831593';

	/**
	 * An invalid id
	 * @var string
	 */
	private string $invalidId = '<Foo>';

	/**
	 * A valid url containing an id
	 * @var string
	 */
	private string $validUrlId = 'https://tv.naver.com/embed/27831593';

	/**
	 * An invalid url
	 * @var string
	 */
	private string $invalidUrlId = 'https://tv.naver.com/video/27831593';

	/**
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\AbstractEmbedService::parseVideoID
	 * @return void
	 */
	public function testInvalidId() {
		$this->expectException( InvalidArgumentException::class );

		new NaverTV( $this->invalidId );
	}

	/**
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\AbstractEmbedService::parseVideoID
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\NaverTV::getUrlRegex
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\NaverTV::getIdRegex
	 * @return void
	 */
	public function testValidId() {
		$service = new NaverTV( $this->validId );

		$this->assertInstanceOf( NaverTV::class, $service );
	}

	/**
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\AbstractEmbedService::parseVideoID
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\NaverTV::getUrlRegex
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\NaverTV::getIdRegex
	 * @return void
	 */
	public function testValidUrlId() {
		$service = new NaverTV( $this->validUrlId );

		$this->assertInstanceOf( NaverTV::class, $service );
		$this->assertSame( '27831593', $service->parseVideoID( $this->validUrlId ) );
	}

	/**
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\AbstractEmbedService::parseVideoID
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\NaverTV::getUrlRegex
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\NaverTV::getIdRegex
	 * @return void
	 */
	public function testInvalidUrlId() {
		$this->expectException( InvalidArgumentException::class );
		new NaverTV( $this->invalidUrlId );
	}

	/**
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\AbstractEmbedService::parseVideoID
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\AbstractEmbedService::getUrl
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\NaverTV::getUrlRegex
	 * @covers \MediaWiki\Extension\EmbedVideo\EmbedService\NaverTV::getIdRegex
	 * @return void
	 */
	public function testUrl() {
		$service = new NaverTV( $this->validUrlId );

		$this->assertStringContainsString( '//tv.naver.com/embed/', $service->getUrl() );
	}
}
