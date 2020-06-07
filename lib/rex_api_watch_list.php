<?php

class rex_api_watch_list extends rex_api_function
{
    protected $published = true;

    public function execute()
    {
        $output     = '';
        $product_id = rex_request('product-id', 'int', 0);
        $func       = rex_request('func', 'string', '');
        $debug       = rex_request('debug', 'int', 0);

        if ($debug) {
            dump(rex_request::session('product_ids'));
        }

        if (!isset($func) || empty($func)) {
            $result = ['errorcode' => 1, rex_i18n::msg('Missing Function!')];
            self::httpError($result);
        }

        $product_ids = rex_request::session('product_ids', 'array', []);


        if ('add' === $func && $product_id) {
            if (!in_array($product_id, $product_ids)) {
                $product_ids[] = $product_id;
            }
            rex_request::setSession('product_ids', $product_ids);
        }

        if ('remove' === $func && $product_id) {
            $product_ids = array_diff($product_ids, [$product_id]);
            rex_request::setSession('product_ids', $product_ids);
        }

        if ('clear' === $func) {
            $product_ids = [];
            rex_request::setSession('product_ids', $product_ids);
        }

        // GENERATE OUTPUT
        
        
        header('Content-Type: text/html; charset=UTF-8');
        //echo $output;
        exit;
    }

    public static function httpError($result)
    {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        exit(json_encode($result));
    }
}
