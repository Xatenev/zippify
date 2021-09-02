# Zippify
This tool allows you to download a generated zip/tar from multiple files.

![Zippify](https://github.com/xatenev/zippify/blob/master/github/Zippify.png?raw=true)

## Web
http://zippify.xatenev.com/

## Features
- Drag and drop functionality
- Select different compression methods
- Password protected archives
- Settings can be stored as bookmarks, e.g. http://zippify.xatenev.com/targz
- Share generated zips with friends
- Full keyboard navigation (press `h` for help on keyboard navigation)
- Virus check uploaded files
- Curl usage available (press `h` for help on curl usage)

## Development

### Setup
````
git clone https://github.com/Xatenev/zippify.git
cd zippify
composer install
composer check-platform-reqs
composer update-signatures
composer start -- 9999
````

### Scripts
> composer start

Start the webserver

> composer update-signatures 

Synchronize virus signatures with clamav

> composer clean

Clean unnecessary files (those that have either not been created with sharing in mind, or those that have expired)

> composer force-clean

Clean all files

## Possible later enhancements
- [ ] decompress functionality (upload zip, get list of files inside. have to be careful here, zipbomb etc.)
- [ ] set archive file name
- [ ] set expire date (currently fixed 1 week)
