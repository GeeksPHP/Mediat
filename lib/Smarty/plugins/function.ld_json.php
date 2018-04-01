<?php
    function smarty_function_ld_json($params, $template)
    {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            $json = json_encode($params['data']);
            $json = str_replace('\\/', '/', $json);
        }else{
            $json = json_encode($params['data'],JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        return sprintf('<script type="application/ld+json">%s</script>',$json);
    }
