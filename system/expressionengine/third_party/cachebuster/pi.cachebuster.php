<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * cachebuster Class
 *
 * @package     ExpressionEngine
 * @category        Plugin
 * @author      Vince Falconi
 * @copyright       Copyright (c) 2015, Vince Falconi
 * @link        https://www.vincefalconi.com
 */

$plugin_info = array(
	'pi_name'         => 'CacheBuster',
	'pi_version'      => '1.0',
	'pi_author'       => 'Vince Falconi',
	'pi_author_url'   => 'https://www.vincefalconi.com',
	'pi_description'  => 'Cachebust an asset request by rewriting the filename to include a timestamp based on the file\'s last modified time.',
	'pi_usage'        => CacheBuster::usage()
);

class CacheBuster
{

	public $return_data = '';

	// --------------------------------------------------------------------

	/**
	 * cachebuster
	 *
	 * @access  public
	 * @return  string
	 */

	public function __construct()
	{

		$path = ee()->TMPL->fetch_param('path');

		// cleanup the path a little bit
		$path = trim($path, './');

		$segments = explode('/', $path);

		$file = $segments[count($segments) - 1];

		$timestamp = filemtime($path);

		$file = $timestamp . '.' . $file;

		if (ee()->TMPL->fetch_param('prepend'))
		{
			$file = ee()->TMPL->fetch_param('prepend') . $file;
		}

		$segments[count($segments) - 1] = $file;

		$path = implode('/', $segments);
		
		if (ee()->TMPL->fetch_param('absolute_path') == 'true')
		{
			$path = ee()->functions->create_url($path);
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


See https://github.com/vfalconi/cachebuster

	<?php
		$buffer = ob_get_contents();
		ob_end_clean();

		return $buffer;
	}
	// END
}
/* End of file pi.crumbs.php */
/* Location: ./system/expressionengine/third_party/crumbs/pi.crumbs.php */