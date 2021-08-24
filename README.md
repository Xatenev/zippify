# Zippify

This tool allows you to download a generated zip from multiple files.

![Zippify](https://github.com/xatenev/zippify/blob/master/github/Zippify.png?raw=true)

## Web

http://zippify.xatenev.com/

## Run dev

````
cd public
php -S localhost:8888
```` 

## Features
- Drag and drop functionality
- Select compression method
- Password protected archives
- Settings can be stored as bookmarks, e.g. http://zippify.xatenev.com/passwordtargz
- Share generated zips with friends

# Todo until v1.0

- phpdoc
- testing
- success/error messages after upload
- keep original file names inside the zip/tar (need db-mapping for this first)
- replace const.php with proper dependency injection
- logging
- responsive mobile view
- help dialogue that explains keyboard navigation and bookmark functionality to the user (its possible to add a route like /targz as browser bookmark to automatically open the page with selected 'tar' and 'gz' settings)
- html validator check
- frontend lib management (npm/bower...)
- ~virus checking~ (doesn't work in a way that makes sense for the user)
- more compression methods (.gz is implemented, bzip2 can still be added)
- keyboard navigation
- save generated zips in db to make sharing with friends possible
- upload limits (file size, file count)
- cleanup file script
- re-adjust setting animation, clicking too fast breaks animation
- dev-experience composer scripts (start server, clean files etc.)

# Possible later enhancements

- decompress functionality (upload zip, get list of files inside. have to be careful here, zipbomb etc.)
