<?php
    /**
     * @author Webfairy MediaT CMS - www.Webfairy.net
     */
    include dirname(__FILE__).'/lib/engine.php';
        $Webfairy = new Webfairy();
            $Webfairy->start();

    function set_option($key, $value)
    {
        setcookie($key, $value, time()+3600);
    }


    if(isset($_GET['rest']) == true){
        foreach ($_COOKIE as $key => $value) {
        	$x = $Webfairy->getOption($key);
            if(isset($x)){
                setcookie($key, null, -1);
            }
            
        }      
    }

    if (isset($_GET['color']) == true) {
        if (preg_match('/^#[a-f0-9]{6}$/i', '#'.$_GET['color'])) {
            set_option('theme_color', '#'.$_GET['color']);

            switch ($_GET['color']) {
                case '67C8F2':
                    set_option('logo_file_id', 49);
                break;

                case 'D63E3D':
                    set_option('logo_file_id', 46);
                break;

                case 'BCCB2F':
                    set_option('logo_file_id', 2);
                break;

                case 'F88C00':
                    set_option('logo_file_id', 50);
                break;

            }
        }
    }

    if (isset($_GET['dir']) == true) {
        switch ($_GET['dir']) {
            case 'rtl':
                set_option('rtl', 1);
            break;

            case 'ltr':
                set_option('rtl', 0);
            break;
        }
    }

    if (isset($_GET['width']) == true) {
        switch ($_GET['width']) {
            case 'full':
                set_option('full_width', 1);
            break;

            case 'fixed':
                set_option('full_width', 0);
            break;
        }
    }

    if (isset($_GET['lang']) == true) {
        switch ($_GET['lang']) {
            case 'en':
                set_option('lang', 'en');
            break;

            case 'ar':
                set_option('lang', 'ar');
            break;
        }
    }
    
    if(isset($_GET['posts_list_style'])){
         set_option('posts_list_style', $_GET['posts_list_style']);
    }
    
    
    if(isset($_GET['reverse_col_order']) == true){
        set_option('reverse_col_order', (int) $_GET['reverse_col_order']);
    }

    if (isset($_GET['main_col']) == true) {
        set_option('main_col', (int) $_GET['main_col']);
    }

    $Webfairy->return_to();
