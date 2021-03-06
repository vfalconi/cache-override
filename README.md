# Cache Override

An EE plugin for generating cache-busting URLs.

Cache Override allows you a flexible means of adding a cache-busting timestamp to your assets, using a customizable pattern parameter.

Cache Override works a lot like EE's built-in {path} variable in that it outputs a URL based on the provided path, but it comes with a few extra features:

- Using the pattern parameter, you can define how the filename should be rewritten. This also allows you to employ [the "revving the filename"](http://www.stevesouders.com/blog/2008/08/23/revving-filenames-dont-use-querystring) technique, placing the timestamp as part of the filename itself, instead of in a query string on the end of the URL.
- The absolute_url parameter gives you the option of an absolute URL (because let's face it, some of us just prefer absolute URLs). (Note: the absolute URL will be based on what you've set as the site URL in your EE configuration.)
- Because Cache Override's output is only the URL, it can be used to rewrite the filename of any asset you need to cache-bust—CSS, JavaScript, images, JSON, whatever.

## Parameters

**Required**
- `path` &mdash; URL path to the file, including filename and extension. This will be scrubbed in the process, so you can start it with a leading slash or a dot-slash if you want, it will end up just fine.

**Optional**
- `pattern` &mdash; Default: `{f}.{t}.{e}`; a string (with placeholders) to determine what your new filename will look like. Placeholders include:
    + `{t}` - timestamp
    + `{f}` - filename (without extension)
    + `{e}` - extension (without preceding dot)

- `absolute_url` &mdash; Default: `false`; if set to `true`, the output will be just like EE's own [`{path}` variable](https://ellislab.com/expressionengine/user-guide/templates/globals/path.html), but the filename will be altered according to the defined pattern.

- `cdn` &mdash; Default: `null`; a CDN domain you want prepended to the cachebusted output.

## Examples

### Basic Usage

```
{exp:cache_override path="assets/css/styles.min.css"}
```

Output:
```html
assets/css/1420665809.styles.min.css
```

### Pattern parameter

```
{exp:cache_override path="/assets/css/styles.min.css" pattern="v-{t}.{f}.{e}"}
```

Output:
```html
assets/css/v-1420665809.styles.min.css
```

### Absolute URL Parameter

```
{exp:cache_override path="./assets/css/styles.min.css" absolute_url="true"}
```

Output:
```html
http://domain.tld/assets/css/1420665809.styles.min.css
```

### CDN

```
{exp:cache_override path="./assets/css/styles.min.css" cdn="https://awesome.cdn.com"}
```

Output:
```
https://awesome.cdn.com/assets/css/1420665809.styles.min.css
```

## Notes
1. I've only tested this on EE 2.9.2, but I don't imagine it breaking on anything from 2.5 and up.
2. If the `path` parameter points to a non-existent file, the resultant request will (most likely) fail. I decided to keep this behavior in place, rather than have the plugin default to the original filename, as a way to gently push you to make sure you're using the cache-busted version of your file.

## Learn more about cache busting:
- The why behind this: http://www.stevesouders.com/blog/2008/08/23/revving-filenames-dont-use-querystring
- URL rewrites with Apache: http://httpd.apache.org/docs/current/mod/mod_rewrite.html
- URL rewrites with IIS: http://www.iis.net/learn/extensions/url-rewrite-module/using-the-url-rewrite-module
