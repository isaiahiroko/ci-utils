<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('to_slug'))
{
    function to_slug($slug)
    {
        return implode('/', explode(':', $slug));
    }   
}

if(!function_exists('starts_with'))
{
    function starts_with($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }
    
}

if(!function_exists('ends_with'))
{
    function ends_with($haystack, $needle)
    {
        $length = strlen($needle);
    
        return $length === 0 || (substr($haystack, -$length) === $needle);
    }

}

if(!function_exists('fill_array'))
{
    function fill_array($input, $length = 0, $pad_with = 0)
    {
        $output = $input;

        end($output);
        $max = key($output) + 1;
        // $max = ($length > $max) ? $length : $max;

        reset($output);
        $min = key($output) - 1;

        for($i = $min; $i <= $max; $i++)
        {
            if(!isset($output[$i])){
                $output[$i] = $pad_with;
            }
        }
        ksort($output);
        // dd([$input, $output, $length, $pad_with, $min, $max]);
        return $output;
    }

}

if(!function_exists('array_group_by_keys'))
{
    // $input must be array of objects|array
    function array_group_by_keys($input)
    {
        return [];
        if(is_array($input)){
            foreach ($input as $input_value) {
                $input_value = is_object($input_value) ? (array) $input_value : $input_value;
                if(is_array($input_value)){
                    foreach ($input_value as $key => $value) {
                        $output[$key][] = $value;
                    }
                }
            }

        }
        return $output;
    }

}

if(!function_exists('prettify'))
{
    function prettify($raw)
    {
        $output = $raw;
        //_at
        // if(ends_with($raw, '_at')){
        //     return date('l jS \of F Y h:i:s A', strtotime($raw));
        // }

        //_id
        // if(ends_with($raw, '_id')){
        //     return $raw;
        // }
            
        //json: array, object
        // if(ends_with($raw, '_id')){}

        //_src: image, file
        // if(preg_match('/(http(s?):)([/|.|\w|\s|-])*\.(?:jpg|gif|png)/g', $raw)){
        //     return "<img src='".$raw."' />";
        // }

        //anchor
        // if(preg_match('/^((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+(\.[a-z]{2,}){1,3}(#?\/?[a-zA-Z0-9#]+)*\/?(\?[a-zA-Z0-9-_]+=[a-zA-Z0-9-%]+&?)?$/g', $output)){
        //     return "<a href='".$raw."' >".$raw."</a>";
        // }

        //boolean
        // if($raw == 0 OR $raw == '0'){
        //     return '<i class="fa fa-check"></i>';
        // }
        // if($raw == 1 OR $raw == '1'){
        //     return '<i class="fa fa-times"></i>';
        // }
        
        return (is_string($output)) ? ucwords(str_replace(array('_', '-'), ' ', $output)) : json_encode($output);
    }
}

if(!function_exists('uglify'))
{
    function uglify($input, $seperator = '_')
    {
        return str_replace(' ', $seperator, strtolower($input));
    }

}
 
if(!function_exists('to_primary'))
{
    function to_primary($entity, $id, $title)
    {
        return (is_null($title) || empty($title)) 
            ? 'NA' 
            : $title; //'<a class="de-anchor" href="'.site_url('/'.$entity.'/collection/'.$id).'" class="">'.$title.'</a>';
    }

}

if(!function_exists('to_at'))
{
    function to_at($column)
    {
        return date('d - m - y', strtotime($column));
    }

}

if(!function_exists('to_src'))
{
    function to_src($column, $title = "")
    {
        return '<a href="'.$column.'" data-lightbox="'.random_string().'" data-title="'.prettify($title).'">
            <img width="32px" height="32px" src='.$column.' />
        </a>';
    }

}

if(!function_exists('to_number'))
{
    function to_number($column)
    {
        return number_format((float) $column);
    }

}

if(!function_exists('to_money'))
{
    function to_money($column)
    {
        return '&#8358; '.number_format((float) $column);
    }

}

if(!function_exists('to_boolean'))
{
    function to_boolean($column)
    {
        return ($column == '1') ? '<i class="fa fa-check ml-3 mx-auto"></i>' : '<i class="fa fa-times ml-3 mx-auto"></i>';
    }

}

if(!function_exists('to_view'))
{
    function to_view($column, $entity)
    {
        return $column;
        // return '<a href="'.site_url('/'.$entity.'/collection/'.$column).'" class="mos-datatable-view-icon" title="View more detail"><i class="fa fa-eye"></i></a>';
    }

}

if(!function_exists('to_actions'))
{
    function to_actions($entity, $entity_id)
    {
        // die(var_dump($entity, $entity_id));
        return '<a href="'.site_url('/'.$entity.'/collection/'.$entity_id).'" class="mos-datatable-view-icon" title="View more detail"><i class="fa fa-eye"></i></a>';
    }

}


if(!function_exists('is_array_equal'))
{
    function is_array_equal($first, $second, $in_order = TRUE)
    {
        return ($in_order) ? $first == $second : !array_diff($first, $second) && !array_diff($second, $first);
    }

}


if(!function_exists('is_array_equal'))
{
    function is_array_equal($first, $second, $in_order = TRUE)
    {
        return ($in_order) ? $first == $second : !array_diff($first, $second) && !array_diff($second, $first);
    }

}
 
if(!function_exists('dd'))
{
    function dd($dump)
    {
        return die(var_dump($dump));
    }

}
 
if(!function_exists('d'))
{
    function d($dump)
    {
        return var_dump($dump);
    }

}

if(!function_exists('rearrange_uploaded_files_array'))
{
    function rearrange_uploaded_files_array($arr){
        foreach( $arr as $key => $all ){
            foreach( $all as $i => $val ){
                $new[$i][$key] = $val;   
            }   
        }
        return $new;
    }
}
 