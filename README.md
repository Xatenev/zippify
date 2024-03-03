# Zippify
This tool allows you to download a generated zip/tar from multiple files and was developed as my submission for a hackathon community challenge.

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

Start the webserver

    composer start -- 9999

Synchronize virus signatures with clamav

    composer update-signatures 

Clean unnecessary files (those that have either not been created with sharing in mind, or those that have expired)

    composer clean

Clean all files

    composer force-clean


## Possible later enhancements
- [ ] decompress functionality (upload zip, get list of files inside. have to be careful here, zipbomb etc.)
- [ ] set archive file name
- [ ] set expire date (currently fixed 1 week)
