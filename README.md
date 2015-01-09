# cachebuster

CacheBuster is an EE plugin that appends a request's filename with a timestamp and an optional string.

## Parameters

**Required**
- `path` - URL path to the file, including filename and extension. This will be scrubbed in the process, so you can start it with a leading slash or a dot-slash if you want, it will end up just fine.

**Optional**
- `absolute_path` - `true` or `false`, defaults to `false`. If set to `true`, the output will be just like EE's own [`{path}` variable](https://ellislab.com/expressionengine/user-guide/templates/globals/path.html), but will include your timestamp and optional prepended string.
- `prepend` - A value to prepend to the filename after the timestamp is added.

{exp:cachebuster path="path/to/asset.ext" prepend="string"}

## Examples

### Basic Usage

```
{exp:cachebuster path="assets/css/styles.min.css"}
```

Output:
```html
assets/css/1420665809.styles.min.css
```

### Absolute URL Parameter

```
{exp:cachebuster path="/assets/css/styles.min.css" absolute_path="true"}
```

Output:
```html
http://domain.tld/assets/css/1420665809.styles.min.css
```

### Prepend parameter

Prepend a string to timestamped filename

```
{exp:cachebuster path="./assets/css/styles.min.css" prepend="v-"}
```

Output:
```html
assets/css/v-1420665809.styles.min.css
```

### Pattern parameter

Specify what you want the output filename to look like using `{t}` as a placeholder for the timestamp, `{f}` as a placeholder for the filename, and `{e}` as a placeholder for the file's extension.

## Learn more about cache busting:
- http://www.stevesouders.com/blog/2008/08/23/revving-filenames-dont-use-querystring
- https://github.com/h5bp
