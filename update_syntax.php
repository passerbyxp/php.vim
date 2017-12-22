<?php

/**
 * Script to gather up all native functions, classes, and interfaces from any
 * release of PHP for the purposes of updating the VIM syntax file.
 *
 * @author Paul Garvin <paul@paulgarvin.net>
 * @copyright Copyright 2009 Paul Garvin
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * @author Stan Angeloff <stanimir@angeloff.name>
 * @author Joshua Sherman <josh@gravityblvd.com>
 * @author Passerby <passerbyxp@gmail.com>
 */

/**
 * This script works by loading up PHP extensions and using reflection to pull
 * the functions, classes, and constants out of those extesions. The list of
 * extensions below are ones included with PHP 5.3 source code. The ones
 * commented out depend on an external library being installed, are Unix
 * specific, or just not commonly used.
 *
 * Add, comment, or uncomment to fit your needs or particular PHP installation.
 * Remember that some of these extensions are likely shared extensions and must
 * be enabled in your php.ini file.
 *
 * NOTE: mysqlnd is not included because it exposes no functions, classes, or
 * constants. The pdo_* extensions are not included in the list because they do
 * not expose any functions, classes, or constants themselves. The constants
 * and methods specific to that driver are exposed though the PDO extension
 * itself. The pdo_* extensions must still be enabled (compiled in or loaded as
 * shared) for these constants to show up.
 */
$extensions = get_loaded_extensions();
sort($extensions,SORT_STRING | SORT_FLAG_CASE);

$processed = [];

foreach ($extensions as $extension)
{
	//if(!extension_loaded($extension)) continue;
	try
	{
		$details = [];
		$options = new ReflectionExtension($extension);

		$classes   = [];
		$functions = array_keys($options->getFunctions());
		$constants = array_keys($options->getConstants());

		foreach ($options->getClasses() as $class)
		{
			$classes[] = $class->getName();
			$constants = array_merge($constants, array_keys($class->getConstants()));
		}

		$constants = array_unique($constants);

		$details['name'] = $options->getName();

		if (sizeof ($functions))
		{
			$details['functions'] = implode(' ', $functions);
		}

		if (sizeof ($constants))
		{
			$details['constants'] = implode(' ', $constants);
		}

		if (sizeof ($classes))
		{
			$details['classes'] = implode(' ', $classes);
		}

		$processed[$extension] = $details;
	}
	catch (Exception $e)
	{
		print "ERROR: '{$extension}' -- " . $e->getMessage() . "\n";
	}
}

$code = "syn case match\n\n";

foreach ($processed as $extension)
{
	if (isset ($extension['constants']))
	{
		$code = $code . '" ' . $extension['name'] . "\n";
		$code = $code . 'syn keyword phpConstants ' . $extension['constants'] . " contained\n\n";
	}
}

$code = $code . "syn case ignore\n\n";

foreach ($processed as $extension)
{
	$code = $code . '" ' . $extension['name'] . "\n";

	if (isset ($extension['functions']))
	{
		$code = $code . 'syn keyword phpFunctions ' . $extension['functions'] . " contained\n";
	}

	if (isset ($extension['classes']))
	{
		$code = $code . 'syn keyword phpClasses ' . $extension['classes'] . " contained\n\n";
	}
}

file_put_contents(
	__DIR__ . '/syntax/php.vim',
	str_replace('${code}', $code, file_get_contents(__DIR__ . '/syntax/php.template')),
	LOCK_EX
);

?>
