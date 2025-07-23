<?php

namespace Ibrahimmusabeh\TextEditor\Decorator;

use Ibrahimmusabeh\TextEditor\Contract\{
    IComponentDecorator,
    ITextComponent
};

class ItalicDecorator implements ITextComponent{

    public function __construct(private ITextComponent $textComponent){}
    public function render():string{
        if (php_sapi_name() === 'cli') {
            return "\033[3m" . $this->textComponent->render() . "\033[23m";  
        } else {
            return "<i>" . $this->textComponent->render() . "</i>";        
        }
    }

    public function getCost():float{
        return $this->textComponent->getCost() + 0.5;
    }


}