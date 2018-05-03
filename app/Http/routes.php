<?php


Route::get('/qr_code', function () {
    $qrCode = new \Endroid\QrCode\QrCode;
    return view('index', ['qr_code' => $qrCode
        ->setText('https://www.google.co.jp')
        ->setSize(300)
        ->setPadding(10)
        ->setErrorCorrection('high')
        ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
        ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
        ->setLabel('My label')
        ->setLabelFontSize(16)])
        ->render();
});

Route::get('/image/qrcode/{text}', [
    'as' => 'qrcode',
    'uses' => function ($text) {
        return Response::stream(function () use ($text) {
            $qrCode = new \Endroid\QrCode\QrCode;
            return $qrCode
                ->setText($text)
                ->setSize(500)
                ->setPadding(10)
                ->setErrorCorrection('high')
                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                ->setLabel('My label')
                ->setLabelFontSize(16)
                ->render();
        });
    }]);


Route::group([
    'prefix' => 'manage'
], function () {
    Route::get('/', function () {
        return view('manage.index');
    });
    Route::resource('qr_code', 'QRCodeController');
});

