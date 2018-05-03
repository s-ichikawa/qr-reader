var app = require('app');
var BrowserWindow = require('browser-window');

var mainWindow = null;
app.on('ready', function () {
    mainWindow = new BrowserWindow({width: 400, height: 600});
    mainWindow.loadURL('file://' + __dirname + '/index.html');
    mainWindow.on('closed', function () {
        mainWindow = null;
    })
});

var ipc = require('electron').ipcMain;
var Canvas = require('canvas')
    , Image = Canvas.Image
    , qrcode = require('jsqrcode')(Canvas);

var fs = require('fs');
var filename = __dirname + '/qrcode.png';

var image = new Image();
var replayEvent;
image.onload = function () {
    // console.log('start decode...');
    var result;
    try {
        result = qrcode.decode(image);
        console.log('result of qr code: ' + result);
        replayEvent.sender.send('url', result);
    } catch (e) {
        // console.log(e);
    }
};

ipc.on('capture', function (event, dataUrl) {
    replayEvent = event;
    fs.writeFile(filename, dataUrl, 'base64', function (error) {
        if (error) {
            alert(error);
        }
        image.src = filename;
    });
});
