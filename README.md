# cachebuster

CacheBuster is an EE plugin that appends a request's filename with a timestamp and an optional string.

Requirements:
- ExpressionEngine 2.9 (See notes below)
- A server with URL rewrites enabled (for more information on this, see "Learn More" below)

## Parameters

**Required**
- `path` &mdash; URL path to the file, including filename and extension. This will be scrubbed in the process, so you can start it with a leading slash or a dot-slash if you want, it will end up just fine.

**Optional**
- `pattern` &mdash; Default: `{f}.{t}.{e}`; a string (with placeholders) to determine what your new filename will look like. Placeholders include:
    + `{t}` - timestamp
    + `{f}` - filename (without extension)
    + `{e}` - extension (without preceding dot)

- `absolute_path` &mdash; Default: `false`; if set to `true`, the output will be just like EE's own [`{path}` variable](https://ellislab.com/expressionengine/user-guide/templates/globals/path.html), but will include your timestamp and optional prepended string.

## Examples

### Basic Usage

```
{exp:cachebuster path="assets/css/styles.min.css"}
```

Output:
```html
assets/css/1420665809.styles.min.css
```

### Pattern parameter

```
{exp:cachebuster path="assets/css/styles.min.css" pattern="v-{t}.{f}.{e}"}
```

Output:
```html
assets/css/v-1420665809.styles.min.css
```

### Absolute URL Parameter

```
{exp:cachebuster path="/assets/css/styles.min.css" absolute_path="true"}
```

Output:
```html
http://domain.tld/assets/css/1420665809.styles.min.css
```

## Notes
1. I've only tested this on EE 2.9.2, but I don't imagine it breaking on anything from 2.5 and up.
2. If the `path` parameter points to a non-existent file, the resultant request will (most likely) fail. I decided to keep this behavior in place, rather than have the plugin default to the original filename, as a way to gently push you to make sure you're using the cache-busted version of your file.

## Learn more about cache busting:
- The why behind this: http://www.stevesouders.com/blog/2008/08/23/revving-filenames-dont-use-querystring
- URL rewrites with Apache: http://httpd.apache.org/docs/current/mod/mod_rewrite.html
- URL rewrites with IIS: http://www.iis.net/learn/extensions/url-rewrite-module/using-the-url-rewrite-module
