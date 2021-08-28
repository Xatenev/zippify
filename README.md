# Zippify

This tool allows you to download a generated zip from multiple files.

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
composer update-signatures
composer start -- 9999
```` 

## Features
- Drag and drop functionality
- Select compression method
- Password protected archives
- Settings can be stored as bookmarks, e.g. http://zippify.xatenev.com/passwordtargz
- Share generated zips with friends

# Todo until v1.0

- [x] responsive mobile view
- [x] disable settings dependent on user input, e.g. tar + password doesn't work together
- [x] cleanup file script
- [x] dev-experience composer scripts (start server, clean files etc.)
- [x] re-adjust settings animation, clicking too fast breaks animation
  
- [ ] virus checking (doesn't work in a way that makes sense for the user, test out phpmussel
- [ ] phpdoc
- [ ] testing
- [ ] success/error messages after upload
- [ ] keep original file names inside the zip/tar (need db-mapping for this first)
- [ ] replace const.php with proper dependency injection
- [ ] logging
- [ ] help dialogue that explains keyboard navigation and bookmark functionality to the user (its possible to add a route like /targz as browser bookmark to automatically open the page with selected 'tar' and 'gz' settings), curl usage
- [ ] html validator check
- [ ] frontend lib management (npm/bower...)
- [ ] more compression methods (.gz is implemented, bzip2 can still be added)
- [ ] keyboard navigation
- [ ] save generated zips in db to make sharing with friends possible
- [ ] upload limits (file size, file count)

# Possible later enhancements

- [ ] decompress functionality (upload zip, get list of files inside. have to be careful here, zipbomb etc.)
