<?php
/**
 * Exports extra hook attributes not imported by the WordPress/phpdoc-parser
 */

namespace WP_Parser_Validate;

use phpDocumentor\Reflection\BaseReflector;
use phpDocumentor\Reflection\ClassReflector\MethodReflector;
use phpDocumentor\Reflection\ClassReflector\PropertyReflector;
use phpDocumentor\Reflection\FunctionReflector;
use phpDocumentor\Reflection\FunctionReflector\ArgumentReflector;
use phpDocumentor\Reflection\ReflectionAbstract;

/**
 *
 *
 * @param string $directory
 *
 * @return array|\WP_Error
 */
function get_wp_files( $directory ) {
	$iterableFiles = new \RecursiveIteratorIterator(
		new \RecursiveDirectoryIterator( $directory )
	);
	$files = array();

	try {
		foreach ( $iterableFiles as $file ) {
			if ( 'php' !== $file->getExtension() ) {
				continue;
			}

			$files[] = $file->getPathname();
		}
	} catch ( \UnexpectedValueException $exc ) {
		if ( class_exists( '\WP_Error' ) ) {
			return new \WP_Error(
				'unexpected_value_exception',
				sprintf( 'Directory [%s] contained a directory we can not recurse into', $directory )
			);
		}
	}

	return $files;
}

/**
 *
 *
 * @param array  $files
 * @param string $root
 *
 * @return array
 */
function parse_files( $files, $root, $content = '' ) {
	$output = array();

	$parser_data = \WP_Parser\parse_files( $files, $root );
	$parser_data = parse_extra_hook_data( $files, $root, $parser_data );

	return $parser_data;
}

function parse_extra_hook_data( $files, $root, $parser_data ) {

	foreach ( $files as $key => $filename ) {

		$file = new File_Reflector( $filename );

		$path = ltrim( substr( $filename, strlen( $root ) ), DIRECTORY_SEPARATOR );
		$file->setFilename( $path );
		$path = str_replace( DIRECTORY_SEPARATOR, '/', $file->getFilename() );

		if ( ! ( isset( $parser_data[ $key ]['path'] ) && ( $path === $parser_data[ $key ]['path'] ) ) ) {
			continue;
		}

		$file->process();

		$parsed_file_hooks = isset( $parser_data[ $key ]['hooks'] ) && ! empty( $parser_data[ $key ]['hooks'] );
		if ( ! empty( $file->uses['hooks'] ) && $parsed_file_hooks ) {
			$parser_data[ $key ]['hooks'] = export_hooks_extra( $file->uses['hooks'], $parser_data[ $key ]['hooks'] );
		}

		foreach ( $file->getFunctions() as $f_key => $function ) {

			if ( ! isset( $parser_data[ $key ]['functions'][ $f_key ]['hooks'] ) ) {
				continue;
			}

			if ( empty( $parser_data[ $key ]['functions'][ $f_key ]['hooks'] ) ) {
				continue;
			}

			$function_hooks = $parser_data[ $key ]['functions'][ $f_key ]['hooks'];

			if ( ! empty( $function->uses ) ) {

				if ( ! empty( $function->uses['hooks'] ) ) {
					$parser_data[ $key ]['functions'][ $f_key ]['hooks'] =  export_hooks_extra( $function->uses['hooks'], $function_hooks );
				}
			}
		}

		foreach ( $file->getClasses() as $c_key => $class ) {

			if ( ! isset( $parser_data[ $key ]['classes'][ $c_key ]['methods'] ) ) {
				continue;
			}


			$i = -1;
			foreach ( $class->getMethods() as $m_key => $method ) {

				++$i;

				if ( ! isset( $parser_data[ $key ]['classes'][ $c_key ]['methods'][ $i ]['hooks'] ) ) {
					continue;
				}


				if ( empty( $parser_data[ $key ]['classes'][ $c_key ]['methods'][ $i ]['hooks'] ) ) {
					continue;
				}

				$method_hooks = $parser_data[ $key ]['classes'][ $c_key ]['methods'][ $i ]['hooks'];

				if ( ! empty( $method->uses ) ) {

					if ( ! empty( $method->uses['hooks'] ) ) {
						$parser_data[ $key ]['classes'][ $c_key ]['methods'][ $i ]['hooks'] =  export_hooks_extra( $method->uses['hooks'], $method_hooks );
					}
				}
			}
		}
	}

	return $parser_data;
}

/**
 * Adds name_raw and concat hook data
 *
 * @param Hook_Reflector[] $hooks
 *
 * @return array
 */
function export_hooks_extra( array $hooks, $parser_data_hooks  ) {

	foreach ( $hooks as $key => $hook ) {
		if ( ! isset( $parser_data_hooks[ $key ]['name'] ) ) {
			continue;
		}

		if ( $hook->getName() !== $parser_data_hooks[ $key ]['name'] ) {
			continue;
		}

		$parser_data_hooks[ $key ]['name_raw'] = $hook->getNameRaw();
		$parser_data_hooks[ $key ]['concat']   = $hook->is_name_concatenated();
	}

	return $parser_data_hooks;
}
