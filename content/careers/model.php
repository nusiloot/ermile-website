<?php
namespace content\careers;


class model extends \mvc\model
{
	public static $url = root.'public_html/files/careers';

	public function post_careers()
	{
		$name   = \dash\request::post("name");
		$number = \dash\request::post("number");
		$type   = \dash\request::post("type");

		if($type != 'php' && $type != 'js' && $type != 'graphic')
		{
			return \lib\debug::error(T_("Type not found"));
		}
		if(!$number)
		{
			return \lib\debug::error(T_("Contact number not set"));
		}
		if(!is_numeric($number))
		{
			return \lib\debug::error(T_("Contact number must be number"));
		}
		if(strlen($number) != 11)
		{
			return \lib\debug::error(T_("Contact number must 11 character"));
		}

		if(strlen($name) > 30)
		{
			$name = substr($name, 0, 30);
		}

		if(!\dash\request::files("file"))
		{
			return \lib\debug::error(T_("You must upload a CV file"));
		}

		$url = self::$url;
		if(!\dash\file::exists($url))
		{
			\dash\file::makeDir($url);
		}
		$url = $url. '/';
		$url .= $type. '_'. $number. '_';
		$url .= \lib\utility\filter::slug($name). '_';
		$url .= '['.\lib\utility\filter::slug(\dash\request::files("file")['name']).']';

		$path = \dash\file::getName(\dash\request::files("file")['name']);
		$path = explode('.', $path);
		$path = end($path);

		$extentionsDisallow = ['php', 'php5', 'htaccess', 'exe', 'bat', 'bin'];
		// if(in_array($path, $extentionsDisallow))
		if($path !== 'pdf')
		{
			return \lib\debug::error(T_("Can not upload this file! only PDF:/"));
		}

		$url = str_replace('-'. $path, '', $url);
		$url .= '.'. $path;

		if(isset(\dash\request::files("file")['tmp_name']))
		{
			if(move_uploaded_file(\dash\request::files("file")['tmp_name'], $url))
			{
				return \lib\debug::true(T_("Thank you. Wait for our call"));
			}
			else
			{
				return \lib\debug::true(T_("We could not upload CV file"));
			}
		}
	}

	public function get_list($_args)
	{
		$file_list = [];
		if (is_dir(self::$url))
		{
		    if ($dh = opendir(self::$url))
		    {
		        while (($file = readdir($dh)) !== false)
		        {
		        	if($file == '.' || $file == '..')
		        	{
		        		continue;
		        	}
		        	$split = explode("_", $file);
		        	$type = null;
		        	if(isset($split[0]))
		        	{
		        		$type = $split[0];
		        	}
		        	$number = null;
		        	if(isset($split[1]))
		        	{
		        		$number = $split[1];
		        	}
		        	$name = null;
		        	if(isset($split[2]))
		        	{
		        		$name = $split[2];
		        	}
		        	$fileRawName = null;
		        	if(isset($split[3]))
		        	{
		        		$fileRawName = $split[3];
		        	}


		            $file_list[] =
		            [
						'file'   => $file,
						'type'   => $type,
						'number' => $number,
						'name'   => $name,
						'fileRawName'   => $fileRawName,
						'date'   => date("Y-m-d H:i:s", filemtime(self::$url. '/'. $file)),
						'url'    => \dash\url::site(). '/files/careers/'. $file
		            ];
		        }
		        closedir($dh);
		    }
		}
		return $file_list;

	}
}
?>