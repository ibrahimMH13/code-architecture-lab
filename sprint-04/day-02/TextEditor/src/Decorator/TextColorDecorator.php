<?php

namespace Ibrahimmusabeh\TextEditor\Decorator;

use Ibrahimmusabeh\TextEditor\Contract\{
    IComponentDecorator,
    ITextComponent
};

class TextColorDecorator implements ITextComponent{

    public function __construct(private ITextComponent $textComponent){}
    public function render(): string
    {
        $content = $this->textComponent->render();
        return php_sapi_name() === 'cli'
            ? "\033[33m{$content}\033[0m"
            : "<span style='color:yellow;'>{$content}</span>";
    }
        
    public function getCost():float{
        return $this->textComponent->getCost() + 2;
    }

}