<?php


namespace Ibrahimmusabeh\TextEditor\Component;

use Ibrahimmusabeh\TextEditor\Contract\ITextComponent;


class TextComponent implements ITextComponent{

    public function __construct(public string $text){}

    public function render():string{
        return $this->text;
    }

    public function getCost():float{
        return 0.0;
    }
}