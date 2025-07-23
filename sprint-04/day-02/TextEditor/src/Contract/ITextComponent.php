<?php


namespace Ibrahimmusabeh\TextEditor\Contract;

interface ITextComponent{

    public function render(): string;
    public function getCost():float;
}   