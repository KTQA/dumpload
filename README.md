# Dumpload - Single Directory File Dump

This package provides access to files in a single directory via a web server.  You can optionally upload and download to the directory.  Security, if any is expected to be provided via the web server.   This package provides none.   It's written to be as simply configured as possible.

This probably doesn't do what you hope it does.

## Requirements

DO YOU HAS A MODERN WEB SERVER WITH:

- Modern PHP with PHAR support
- Aliases
- SetEnv for environment variables
- XSendFile support

It has been tested using apache and lighttpd, the latter being the primary target.   Example configuration options are available in `share`.  Only tested in Linux.


## Usage

Get or make the phar, and then update your configuration to have an alias which points to it.  Set an environment variable called `DUMPLOADDIR` which then points to the directory you want to manage.   Assuming you have read capability into that directory you'll then see those files as an index.

If you create a text file called `README` in that directory, it will be included at the top of the page and not show up in the file list.

This doesn't offer much more than autoindexes, doesn't it?

### Configuration

Create a file called `.dumpload.ini` in the `DUMPLOADDIR` directory.   An example is available in `share/example.dumpload.ini`.  Using the options therein, you can give the page a nice title, add file deletion and uploading (using [dropzone.js](https://www.dropzonejs.com/)), and highlight files that are older than a certain number of days.

### Building

Run `build.php` to create a file called `dumpfile.phar`.

## Possible Future Plans

- simple logging
- Theming
- i18n
- audio transcoding
- maybe filename normalization

## Security Considerations

*None.   None at all.*

This is pile of code that lets you upload and download arbitrary files to a directory, limited only by the webserver itself.   Care has been taken to prevent the code from leaving its directory, but not much care.  I thought about adding something that would complain if you put this on a public IP but that would suggest that this code cares about security, so no.

This is for very specific use cases in closed environments.   Use at your own risk.

## What's With the Name?

> **Me:** So you know the upload and download pages for the studio?  I've normalized them into a functional piece of code that can actually be used in places.   I mean, it's a "security nightmare" as it just lets people arbitrarily upload crap if it's configured the right way.\
> 
> **Me:** That's not the point though.
> 
> **Me:** The point is I wanted to give it a name that says "this might be unpleasant."
> 
> **Me:** I went with "dumpload"
> 
> **R**:  ahahahahah
> 
> **R**: my first thought was "barf bag"
> 
> **Me:** kind of a combined portmanteau of "download"  "upload" and "dumb"
> 
> **S:** Sounds less unpleasant than crap chute

## License

The heavy lifting in Dropzone is MIT.   My crap is AGPL3.

