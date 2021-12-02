<?php 
namespace app\core\form;

use app\models\Model;

class Form
{
    public static function begin($action, $method)
    {
        echo "<form action='{$action}' method='{$method}'>"; 
        return new Form(); 
    }

    public function end()
    {
        echo "</form>";
    }

    public function filed(Model $model, string $attribute, string $filedName)
    {
        return new Field($model, $attribute, $filedName);
    }
}

