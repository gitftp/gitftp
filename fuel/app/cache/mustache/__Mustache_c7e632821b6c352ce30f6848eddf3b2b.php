<?php

class __Mustache_c7e632821b6c352ce30f6848eddf3b2b extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!doctype html>
';
        $buffer .= $indent . '<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
';
        $buffer .= $indent . '<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
';
        $buffer .= $indent . '<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
';
        $buffer .= $indent . '<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
';
        $buffer .= $indent . '    <head>
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('header'), $context, $indent);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('css'), $context, $indent);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('js'), $context, $indent);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '    </head>
';
        $buffer .= $indent . '    <body>
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('body'), $context, $indent);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('footer'), $context, $indent);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '    </body>
';
        $buffer .= $indent . '</html>
';

        return $buffer;
    }
}
