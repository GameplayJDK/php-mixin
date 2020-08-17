<?php
/*
 * MIT License
 *
 * Copyright (c) 2020 GameplayJDK
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

require dirname(__DIR__) . '/vendor/autoload.php';

use Mixin\DynamicInheritance;

/**
 * Class SomeMixinClass
 */
class SomeMixinClass
{
    /**
     * @var int
     */
    public $priority = 7;

    public function sayHello(): void
    {
        echo 'hello', PHP_EOL;
    }
}

/**
 * Class SomeParentClass
 */
class SomeParentClass
{
    use DynamicInheritance;
}

// You could either add the mixin this way, which would require adding the mixin to each instance every time an instance
// is created (also, the IDE will not pick up, which methods and properties are dynamically available):
$someInstance = new SomeParentClass();
$someInstance->addMixin(new SomeMixinClass());

$someInstance->sayHello();
echo $someInstance->priority, PHP_EOL;

// Or do it like this, in which case each and every instance will have the same mixin (and the IDE will pick up, which
// methods and properties are available dynamically):


/**
 * Class SomeChildClass
 * @method sayHello()
 * @property int priority
 */
class SomeChildClass extends SomeParentClass
{
    /**
     * SomeChildClass constructor.
     */
    public function __construct()
    {
        $this->addMixin(new SomeMixinClass());
    }
}

$thatInstance = new SomeChildClass();

$thatInstance->sayHello();
echo $thatInstance->priority, PHP_EOL;

// While option 2 is somewhat more explicit, it is the recommended way of using this library. Please keep in mind, that
// the proper way of using the mixin feature highly depends on your use-case.
