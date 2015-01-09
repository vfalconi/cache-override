# cachebuster

CacheBuster is an EE plugin that appends a request's filename with a timestamp and an optional string.

## Parameters

**Required**
- `path` &mdash; URL path to the file, including filename and extension. This will be scrubbed in the process, so you can start it with a leading slash or a dot-slash if you want, it will end up just fine.

**Optional**
- `pattern` (Default: `{f}.{t}.{e}`) &mdash; string (with placeholders) to determine what your new filename will look like. Placeholders include:
    + `{t}` - timestamp
    + `{f}` - filename (without extension)
    + `{e}` - extension (without preceding dot)

- `absolute_path` (Default: `false`) &mdash; If set to `true`, the output will be just like EE's own [`{path}` variable](https://ellislab.com/expressionengine/user-guide/templates/globals/path.html), but will include your timestamp and optional prepended string.

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

## Learn more about cache busting:
- http://www.stevesouders.com/blog/2008/08/23/revving-filenames-dont-use-querystring
- https://github.com/h5bp
