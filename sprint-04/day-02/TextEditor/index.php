<?php


require 'vendor/autoload.php';


use Ibrahimmusabeh\TextEditor\Component\TextComponent;
use Ibrahimmusabeh\TextEditor\Decorator\{
    BoldDecorator,
    ItalicDecorator,
    TextColorDecorator,
    BgColorDecorator
};

 $editor = new TextComponent("Ibrahim I. I. Musabeh \n");
 $editor = new BoldDecorator($editor);
 $editor = new ItalicDecorator($editor);
 $editor = new BgColorDecorator($editor);
 $editor = new TextColorDecorator($editor);

 echo $editor->render();
