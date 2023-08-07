Responsive images change log
=================

Version 2.2.0 (2023-08-07)
-------------------------
- Overhaul of element
- CSS backgrounds only
- Configurable breakpoints
- Twig template
- Added aria role
- Tidied up field names

Version 2.1.1 (2023-02-16)
-------------------------
- Always use 'public' as webroot for Contao 5

Version 2.1.0 (2022-11-21)
-------------------------
- Update for Contao 5
- Remove 100% width option
- Improve caching of CSS
- Improve loading of JS for non-CSS background images

Version 2.0.5 (2022-08-19)
-------------------------
- Add compatability with sites using "public" web root

Version 2.0.4 (2022-06-08)
-------------------------
- Fix undefined array key error from DCA
- Remove labels from DCA
- Use contao.image.sizes service for fetching image sizes

Version 2.0.3 (2022-4-11)
--------------------------

### Updated
Use minified JS file.

Version 2.0.2 (2021-12-09)
--------------------------

### Updated
Show preview of image in BE.


Version 2.0.1 (2021-11-15)
--------------------------

### Updated
Improve handling of opengraph tag: Make OG tag optional and only allow once per page.

Version 2.0.0 (2020-09-24)
--------------------------
Release version 2.0.0

Version 1.0.22 (2019-10-15)
--------------------------

### Updated
Don't use Contao's singleSRC field

Version 1.0.21 (2019-10-15)
--------------------------

### Fixed
Fix full size image option when using presets

Version 1.0.20 (2019-10-10)
--------------------------

### Updated
Move content element to Element namespace
Update namespace name
Use new image factory

Version 1.0.19 (2019-08-07)
--------------------------

### Updated
Pull metadata from file manager

Version 1.0.18 (2019-05-10)
--------------------------

### Updated
Added support for global image size presets

Version 1.0.17 (2019-02-08)
--------------------------

### Updated
Added support for contao manager


Version 1.0.16 (2018-02-21)
--------------------------

### Updated
Added support for og tags


Version 1.0.15 (2017-07-24)
--------------------------

### Fixed
Clear form fields on tl_content
Remove reference to tl_content class

Version 1.0.14 (2017-02-28)
--------------------------

## Updated
Remove symfony dependency to work with latest version of Contao

### Fixed
Make sure breakpoints are available in the module


Version 1.0.13 (2017-02-28)
--------------------------

## Updated
Remove symfony dependency to work with latest version of Contao

### Fixed
Make sure breakpoints are available in the module

Version 1.0.12 (2016-11-03)
--------------------------

### Fixed
Make sure breakpoints are available in the module

Version 1.0.11 (2016-10-26)
--------------------------

### Changed
Make JS breakpoints available at all times, even if no module is present on page

Version 1.0.10 (2016-03-01)
--------------------------

### Fixed
Allow breakpoints to be defined in config and apply to CSS images

Version 1.0.9 (2016-03-01)
--------------------------

### Feature
Allow image breakpoints to be overridden with JS

Version 1.0.8 (2015-09-16)
--------------------------

### Fixed
Used named JS file to prevent duplication
Load a single JS to the minified JS to prevent multiple minified JS files
Don't include CSS in minifyed CSS to prevent multiple minifyed CSS file

Version 1.0.7 (2015-08-18)
--------------------------

### Feature
Implement all contao cropping modes

Version 1.0.6 (2015-08-18)
--------------------------

### Fixed
Make sure JS is loaded for non-css background images

Version 1.0.5 (2015-08-18)
--------------------------

### Fixed
Fix bug where debug mode was being forced on

Version 1.0.4 (2015-08-18)
--------------------------

### Fixed
Fix autoload paths
Fix asset links

Version 1.0.3 (2015-08-18)
--------------------------

### Fixed
Updated to support Contao 4

Version 1.0.2 (2015-08-18)
--------------------------

### Fixed
Updated to support Contao 4

Version 1.0.1 (2015-08-18)
--------------------------

### Fixed
Updated to support Contao 4
