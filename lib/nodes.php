<?php
namespace WP_Parser_Validate;

function get_name( $node ) {
	return isset( $node['name'] ) ?  trim( $node[ 'name'] ) : '';
}

function get_name_raw( $node ) {
	return isset( $node['name_raw'] ) ? trim( $node[ 'name_raw'] ) : '';
}

function get_type( $node ) {
	return isset( $node['type'] ) ?  trim( $node[ 'type'] ) : '';
}

function get_line( $node ) {
	return isset( $node[ 'line'] ) ?  abs( intval( $node[ 'line'] ) ) : '';
}

function get_end_line( $node ) {
	return isset( $node['end_line'] ) ? abs( intval( $node['end_line'] ) ) : '';
}

function get_visibility( $node ) {
	return isset( $node['visibility'] ) ? trim( $node['visibility'] ) : '';
}

function get_uses( $node ) {
	return isset( $node['uses'] ) ? $node['uses'] : array();
}

function get_parameters( $node ) {
	return isset( $node['arguments'] ) ? $node['arguments'] : array();
}

function get_docblock( $node ) {
	return isset( $node['doc'] ) ? $node['doc'] : array();
}

function get_doc_description( $node ) {
	return isset( $node['doc']['description'] ) ? trim( $node['doc']['description'] ) : '';
}

function get_doc_long_description( $node ) {
	return isset( $node['doc']['long_description'] ) ? trim( $node['doc']['long_description'] ) : '';
}

function get_doc_tags( $node ) {
	return isset( $node['doc']['tags'] ) ? $node['doc']['tags'] : array();
}

function get_doc_params( $node ) {
	return array_values( filter( get_doc_tags( $node ), array( 'name' => 'param' ) ) );
}

function get_doc_params_key( $node, $key ) {
	return array_map( function( $val ) use ( $key ) {
			return isset( $val[ $key ] ) ? trim( $val[ $key ] ) : '';
		}, get_doc_params( $node ) );
}

function get_doc_since( $node ) {
	return array_values( filter( get_doc_tags( $node ), array( 'name' => 'since' ) ) );
}

function get_doc_var( $node ) {
	return array_values( filter( get_doc_tags( $node ), array( 'name' => 'var' ) ) );
}

function get_doc_return( $node ) {
	return array_values( filter( get_doc_tags( $node ), array( 'name' => 'return' ) ) );
}

function get_functions( $node ) {
	$node = get_uses( $node );
	return isset( $node['functions'] ) ? $node['functions'] : array();
}

function get_function_names( $node ) {
	$names = array_map( function( $val ) {
			return isset( $val['name'] ) ? trim( $val['name'] ) : '';
		}, get_functions( $node ) );

	return array_filter( array_unique( $names ) );
}

function get_parameter_names( $node ) {
	$parameters = array_map( function( $val ) {
			return isset( $val['name'] ) ? trim( $val['name'] ) : trim( $val );
		}, get_parameters( $node ) );

	return array_values( $parameters );
}

function get_doc_return_types( $node ) {
	$node = get_doc_return( $node );

	if ( ! ( isset( $node[0]['types'] ) && $node[0]['types'] ) ) {
		return array();
	}

	return array_values( $node[0]['types'] );
}

function get_doc_access( $node ) {
	$node = array_values( filter( get_doc_tags( $node ), array( 'name' => 'access' ) ) );

	if ( !isset( $node[0]['content'] ) ) {
		return '';
	}

	return trim( (string) $node[0]['content'] );
}
