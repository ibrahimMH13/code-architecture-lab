<?php

namespace Ibrahimmusabeh\TextEditor\Decorator;

use Ibrahimmusabeh\TextEditor\Contract\{
    IComponentDecorator,
    ITextComponent
};

class BgColorDecorator implements ITextComponent{

    public function __construct(private ITextComponent $textComponent){}
    public function render():string{
        if (php_sapi_name() === 'cli') {
            return "\033[48;2;34;139;34m" . $this->textComponent->render() . "\033[49m";  
        } else {
           return "<span style='color:red'>" . $this->textComponent->render() . "</span>"; 
        }
    }

    public function getCost():float{
        return $this->textComponent->getCost() + 2;
    }

}