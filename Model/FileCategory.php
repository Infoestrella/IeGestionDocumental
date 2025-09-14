<?php

namespace Facturascripts\Plugins\IeGestionDocumental\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;

class FileCategory extends ModelClass
{
    use ModelTrait;

    public $id;   
    public $name;

    public function clear()
    {
        parent::clear();
    }

    public static function primaryColumn(): string
    {
        return 'id';
    }

    public static function tableName(): string {
        return 'filecategories';
    }
}
