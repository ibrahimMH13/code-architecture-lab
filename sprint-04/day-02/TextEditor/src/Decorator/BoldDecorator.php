<?php

namespace Ibrahimmusabeh\TextEditor\Decorator;

use Ibrahimmusabeh\TextEditor\Contract\{
    IComponentDecorator,
    ITextComponent
};

class BoldDecorator implements ITextComponent{

    public function __construct(private ITextComponent $textComponent){}
    public function render():string{
        if (php_sapi_name() === 'cli') {
           return "\033[1m" . $this->textComponent->render() . "\033[22m";
        } else {
           return "<b>" . $this->textComponent->render() . "</b>"; 
        }
    }

    public function getCost():float{
        return $this->textComponent->getCost() + 1;
    }

}