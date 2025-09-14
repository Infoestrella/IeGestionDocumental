<?php

namespace Facturascripts\Plugins\IeGestionDocumental\Controller;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Lib\ExtendedController\EditController;

class EditFilecategory extends EditController
{
    public function getModelClassName(): string
    {
        return 'FileCategory';
    }

    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'category';
        $data['icon'] = 'fa-solid fa-folder-tree';
        $data['menu'] = 'document-management';
        return $data;
    }

    protected function createViews()
    {
        parent::createViews();
        $this->setTabsPosition('bottom');
        $this->addListView('ListAttachedFile', 'AttachedFile', 'files');
    }


    protected function loadData($viewName, $view)
    {
        switch ($viewName) {
            case 'ListAttachedFile':
                $idcategory = $this->getViewModelValue('EditFileCategory', 'id');
                $where = [new DataBaseWhere('idfilecategory', $idcategory)];
                $view->loadData('', $where);
                break;

            case 'EditFileCategory':
                parent::loadData($viewName, $view);
                if(!$this->views[$viewName]->model->exists()){
                    $this->views[$viewName]->model->user = $this->user->nick;
                }
                break;
        }
    }
}
