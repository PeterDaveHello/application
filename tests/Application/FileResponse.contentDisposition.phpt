<?php

/**
 * Test: Nette\Application\Responses\FileResponse.
 */

use Nette\Application\Responses\FileResponse,
	Nette\Http,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';


test(function() {
	$file = __FILE__;
	$fileResponse = new FileResponse($file);
	$origData = file_get_contents($file);

	$fileInfo = pathinfo($file);
	$fileName = $fileInfo['filename'] . '.' . $fileInfo['extension'];

	ob_start();
	$fileResponse->send(new Http\Request(new Http\UrlScript), $response = new Http\Response);

	Assert::same( $origData, ob_get_clean() );
	Assert::same( 'attachment; filename="' . $fileName . '"', $response->getHeader('Content-Disposition') );
});


test(function() {
	$file = __FILE__;
	$fileResponse = new FileResponse($file, NULL, NULL, FALSE);
	$origData = file_get_contents($file);

	$fileInfo = pathinfo($file);
	$fileName = $fileInfo['filename'] . '.' . $fileInfo['extension'];

	ob_start();
	$fileResponse->send(new Http\Request(new Http\UrlScript), $response = new Http\Response);

	Assert::same( $origData, ob_get_clean() );
	Assert::same('inline; filename="' . $fileName . '"', $response->getHeader('Content-Disposition'));
});
