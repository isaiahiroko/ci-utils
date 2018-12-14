<?php defined('BASEPATH') OR exit('No direct script access allowed');

use voku\helper\HtmlMin;

class Compressor_service{
    
    protected $CI;
    
    public $minify = false;
    public $uglify = false;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function compress($input, $minify = true, $uglify = true)
    {
        $this->minify = $minify;
        $this->uglify = $uglify;

        if($this->minify == true){
            $output = $this->minify($input);
        }

        if($this->uglify == true){
            $output = $this->uglify($input);
        }

        return $output;
    }

    public function minify($input)
    {
        $htmlMin = new HtmlMin();

        // $htmlMin->doOptimizeViaHtmlDomParser();               // optimize html via "HtmlDomParser()"
        // $htmlMin->doRemoveComments();                         // remove default HTML comments (depends on "doOptimizeViaHtmlDomParser(true)")
        // $htmlMin->doSumUpWhitespace();                        // sum-up extra whitespace from the Dom (depends on "doOptimizeViaHtmlDomParser(true)")
        // $htmlMin->doRemoveWhitespaceAroundTags();             // remove whitespace around tags (depends on "doOptimizeViaHtmlDomParser(true)")
        // $htmlMin->doOptimizeAttributes();                     // optimize html attributes (depends on "doOptimizeViaHtmlDomParser(true)")
        // $htmlMin->doRemoveHttpPrefixFromAttributes();         // remove optional "http:"-prefix from attributes (depends on "doOptimizeAttributes(true)")
        // $htmlMin->doRemoveDefaultAttributes();                // remove defaults (depends on "doOptimizeAttributes(true)" | disabled by default)
        // $htmlMin->doRemoveDeprecatedAnchorName();             // remove deprecated anchor-jump (depends on "doOptimizeAttributes(true)")
        // $htmlMin->doRemoveDeprecatedScriptCharsetAttribute(); // remove deprecated charset-attribute - the browser will use the charset from the HTTP-Header, anyway (depends on "doOptimizeAttributes(true)")
        // $htmlMin->doRemoveDeprecatedTypeFromScriptTag();      // remove deprecated script-mime-types (depends on "doOptimizeAttributes(true)")
        // $htmlMin->doRemoveDeprecatedTypeFromStylesheetLink(); // remove "type=text/css" for css links (depends on "doOptimizeAttributes(true)")
        // $htmlMin->doRemoveEmptyAttributes();                  // remove some empty attributes (depends on "doOptimizeAttributes(true)")
        // $htmlMin->doRemoveValueFromEmptyInput();              // remove 'value=""' from empty <input> (depends on "doOptimizeAttributes(true)")
        // $htmlMin->doSortCssClassNames();                      // sort css-class-names, for better gzip results (depends on "doOptimizeAttributes(true)")
        // $htmlMin->doSortHtmlAttributes();                     // sort html-attributes, for better gzip results (depends on "doOptimizeAttributes(true)")
        // $htmlMin->doRemoveSpacesBetweenTags();                // remove more (aggressive) spaces in the dom (disabled by default)
        // $htmlMin->doRemoveOmittedQuotes();                    // remove quotes e.g. class="lall" => class=lall
        // $htmlMin->doRemoveOmittedHtmlTags();  

        $output = $htmlMin->minify($input);
   
        return $output;     
    }

    public function uglify($input)
    {
        $output = $input;     
        return $output;     
    }
    
}