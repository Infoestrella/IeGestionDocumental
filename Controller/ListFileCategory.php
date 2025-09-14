<?php

namespace FacturaScripts\Plugins\IeGestionDocumental\Controller;

use FacturaScripts\Core\Lib\ExtendedController\ListController;

class ListFileCategory extends ListController
{
    public function getPageData(): array
    {
        $pageData = parent::getPageData();
        $pageData['menu'] = 'document-management';
        $pageData['title'] = 'categories';
        $pageData['icon'] = 'fa-solid fa-folder-tree';
        return $pageData;
    }

    protected function createViews()
    {
        $this->addView('ListFileCategory', 'FileCategory');
        $this->addSearchFields('ListFileCategory', ['name']);
        $this->addOrderBy('ListFileCategory', ['name']);
    }
}
