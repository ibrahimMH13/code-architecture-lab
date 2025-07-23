<?php

require 'vendor/autoload.php';

use Ibrahimmusabeh\TextEditor\Component\TextComponent;
use Ibrahimmusabeh\TextEditor\Decorator\{
    BoldDecorator,
    ItalicDecorator,
    TextColorDecorator,
    BgColorDecorator
};

echo "Testing individual decorators:\n";


$allDecorators = new TextColorDecorator(
    new BgColorDecorator(
        new ItalicDecorator(
            new BoldDecorator(new TextComponent("All Decorators"))
        )
    )
);
echo "***. All decorators: " . $allDecorators->render() . "\n";
