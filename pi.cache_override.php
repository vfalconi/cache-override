<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * cache_override Class
 *
 * @package     ExpressionEngine
 * @category        Plugin
 * @author      Vince Falconi
 * @copyright       Copyright (c) 2015, Vince Falconi
 * @link        https://www.vincefalconi.com
 */

$plugin_info = array(
	'pi_name'         => 'cache_override',
	'pi_version'      => '1.0',
	'pi_author'       => 'Vince Falconi',
	'pi_author_url'   => 'https://www.vincefalconi.com',
	'pi_description'  => 'Override (cache-bust) a cached asset request with a rewritten the filename including a timestamp based on the file\'s last modified time.',
	'pi_usage'        => cache_override::usage()
);

class cache_override
{

	public $return_data = '';

	// --------------------------------------------------------------------

	/**
	 * cache_override
	 *
	 * @access  public
	 * @return  string
	 */

	public function __construct()
	{

		$path = ee()->TMPL->fetch_param('path');
		$pattern = ee()->TMPL->fetch_param('pattern');

		// cleanup the path a little bit
		$path = trim($path, './');

		// break up the path segments
		$segments = explode('/', $path);

		// grab the asset's filename + extension
		$file = $segments[count($segments) - 1];

		// create the file's timestamp based on its last-modified-time
		$timestamp = filemtime($path);

		// get the extension of the file, without the accompanying dot
		preg_match('/\.([A-Za-z]+)$/', $file, $matches);
		$extension = trim($matches[0], '.');

		// get the basename of the file
		$basename = substr($file, 0, strlen($file) - strlen($extension));
		$basename = trim($basename, '.');

		// create the new filename using the supplied pattern
		// if no pattern, default to `{f}.{t}.{e}`

		if ($pattern == '')
		{
			$pattern = '{f}.{t}.{e}';
		}

		// REGEX YOU ARE MY LOVAH
		$variables[0] = '/\{t\}/';
    $variables[1] = '/\{f\}/';
    $variables[2] = '/\{e\}/';

    $values[0] = $timestamp;
    $values[1] = $basename;
    $values[2] = $extension;
		
		$segments[count($segments) - 1] = preg_replace($variables, $values, $pattern);

		// rebuild URL
		$path = implode('/', $segments);

		// if the `absolute_url` parameter is set to true, oblige the request
		if (ee()->TMPL->fetch_param('absolute_url') == 'true')
		{
			$path = ee()->functions->create_url($path);
		}

		// if a CDN URL is provided, use it
		if (null !== ee()->TMPL->fetch_param('cdn'))
		{
			$path = ee()->TMPL->fetch_param('cdn') . $path;
		}

		$this->return_data = $path;
		
	}

	// --------------------------------------------------------------------

	/**
	 * Usage
	 *
	 * This function describes how the plugin is used.
	 *
	 * @access  public
	 * @return  string
	 */
	public static function usage()
	{
		ob_start();  ?>


See https://github.com/vfalconi/cache_override

	<?php
		$buffer = ob_get_contents();
		ob_end_clean();

		return $buffer;
	}
	// END
}
/* End of file pi.cache_override.php */
/* Location: ./system/expressionengine/third_party/cache_override/pi.cache_override.php */
