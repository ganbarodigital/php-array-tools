# CHANGELOG

## develop branch

### New

* Added support for extracting the first non-empty entry from a list
  - Added `Filters\ExtractFirstItemWithContent`

## 1.2.0 - Fri 29th Jan 2016

### New

* Added support for extracting the first entry from a list
  - Added `Filters\ExtractFirstItem`

## 1.1.0 - Thu 28th Jan 2016

### New

* Added the basic exception hierarchy
  - Added `Exxx_ArrayToolsException`
  - Added `E4xx_ArrayToolsException`
  - Added `E4xx_UnsupportedType`
* Added support for converting key/value pairs in a string into an array
  - Added `Parsers\ConvertKeyValuePairsToArray`

## 1.0.0 - Thu 28th Jan 2016

### New

* Added support for converting data types to a real PHP array
  - Added `ValueBuilders\ConvertToArray`