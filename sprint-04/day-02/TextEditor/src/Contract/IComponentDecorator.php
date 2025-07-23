<?php

namespace Ibrahimmusabeh\TextEditor\Contract;
use Ibrahimmusabeh\TextEditor\Contract\ITextComponent;

interface IComponentDecorator {
     
    public function render();
    public function getCost();
}