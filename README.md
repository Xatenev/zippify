# Zippify
This tool allows you to download a generated zip/tar from multiple files.

![Zippify](https://github.com/xatenev/zippify/blob/master/github/Zippify.png?raw=true)

## Web
Username: admin 

Password: 123 

http://zippify.xatenev.com/

## Run dev
````
git clone https://github.com/Xatenev/zippify.git
cd zippify
composer install
composer check-platform-reqs
composer update-signatures
composer start -- 9999
```` 

## Features
- Drag and drop functionality
- Select compression method
- Password protected archives
- Settings can be stored as bookmarks, e.g. http://zippify.xatenev.com/passwordtargz
- Share generated zips with friends

## Scripts
> composer start

Start the webserver

> composer update-signatures 

Synchronize virus signatures with clamav

> composer clean

Clean unnecessary files (those that have either not been created with sharing in mind, or those that have expired)

> composer force-clean

Clean all files

# Todo until v1.0

- [x] responsive mobile view
- [x] disable settings dependent on user input, e.g. tar + password doesn't work together
- [x] cleanup file script
- [x] dev-experience composer scripts (start server, clean files etc.)
- [x] re-adjust settings animation, clicking too fast breaks animation
- [x] virus checking
- [x] logging
- [x] more compression methods (.gz, .bzip2)
- [x] keyboard navigation
- [x] help dialogue that explains keyboard navigation and bookmark functionality to the user (its possible to add a route like /targz as browser bookmark to automatically open the page with selected 'tar' and 'gz' settings), curl usage
- [x] keep original file names inside the zip/tar (need db-mapping for this first)
- [x] save generated zips to make sharing possible
- [x] automatically change url when settings are enabled/disabled
- [x] Add clean command to remove expired files
  
- [ ] Add force clean command to remove everything
- [ ] google lighthouse report
- [ ] frontend lib management (npm/bower...)
- [ ] upload limits (file size, file count)

# Possible later enhancements

- [ ] decompress functionality (upload zip, get list of files inside. have to be careful here, zipbomb etc.)
- [ ] set zip file name