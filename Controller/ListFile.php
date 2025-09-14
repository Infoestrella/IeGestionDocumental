<?php

namespace FacturaScripts\Plugins\IeGestionDocumental\Controller;

use FacturaScripts\Core\Lib\ExtendedController\ListController;

class ListFile extends ListController
{
    public function getPageData(): array
    {
        $pageData = parent::getPageData();
        $pageData['menu'] = 'document-management';
        $pageData['title'] = 'files';
        $pageData['icon'] = 'fa-solid fa-file';
        return $pageData;
    }

    protected function createViews(string $viewName = 'ListAttachedFile')
    {
        $this->addView($viewName, 'AttachedFile');
        $this->addSearchFields($viewName, ['description']);
        $this->addOrderBy($viewName, ['idfile'], 'id', 2);
        $this->addFilterAutocomplete($viewName, 'idfilecategory', 'category', 'idfilecategory', 'filecategories', 'id', 'name');
    }
}
