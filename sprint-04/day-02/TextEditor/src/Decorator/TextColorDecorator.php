<?php

namespace Ibrahimmusabeh\TextEditor\Decorator;

use Ibrahimmusabeh\TextEditor\Contract\{
    IComponentDecorator,
    ITextComponent
};

class TextColorDecorator implements ITextComponent{

    public function __construct(private ITextComponent $textComponent){}
    public function render():string{
        if (php_sapi_name() === 'cli') {
            return "\033[93m" . $this->textComponent->render() . "\033[39m";
        } else {
           return "<span style='color:red'>" . $this->textComponent->render() . "</span>"; 
        }
    }

    public function getCost():float{
        return $this->textComponent->getCost() + 2;
    }

}