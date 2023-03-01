<?php

class __Mustache_1ee914e9bb7721b0f54b7b2f396296bf extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<a href="';
        $value = $this->resolveValue($context->find('url'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" target="_blank">
';
        $buffer .= $indent . '    ';
        $value = $context->find('pix');
        $buffer .= $this->section18f7d4430b7a3643089a0bf75206ee2c($context, $indent, $value);
        $value = $context->find('str');
        $buffer .= $this->sectionF8a1533dcefdb25763dd21c9bb3f5d57($context, $indent, $value);
        $buffer .= '<span class="ml-1">';
        $value = $context->find('pix');
        $buffer .= $this->sectionC39b10c42f65bf4b9f12a00911cf13a3($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '</a>
';

        return $buffer;
    }

    private function section18f7d4430b7a3643089a0bf75206ee2c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'i/bullhorn, core';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'i/bullhorn, core';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF8a1533dcefdb25763dd21c9bb3f5d57(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'calltofeedback_give';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'calltofeedback_give';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD5d6ff3f0463d3a1689465808bc0d547(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'opensinnewwindow';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'opensinnewwindow';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC39b10c42f65bf4b9f12a00911cf13a3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'i/externallink, core, {{#str}}opensinnewwindow{{/str}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'i/externallink, core, ';
                $value = $context->find('str');
                $buffer .= $this->sectionD5d6ff3f0463d3a1689465808bc0d547($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
