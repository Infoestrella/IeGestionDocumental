<?php

namespace FacturaScripts\Plugins\IeGestionDocumental\Controller;

use FacturaScripts\Core\Base\Controller;
use FacturaScripts\Core\Model\AttachedFile;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;

class DocumentManager extends Controller
{
    public $folderActual;
    public $subfolders = [];
    public $files = [];
    public $breadcrumbs = [];

    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['menu'] = 'document-management'; // o el menú que quieras
        $data['title'] = 'document-management';
        $data['icon'] = 'fa fa-folder';
        return $data;
    }

    public function privateCore(&$response, $user, $permissions)
    {
        parent::privateCore($response, $user, $permissions);

        $this->treeData = $this->buildTreeData();
    }

    private function buildTreeData(): array
    {
        $nodes = [];

        // Nodo raíz
        $nodes[] = [
            'id' => 'root',
            'parent' => '#',
            'text' => 'root',
            'icon' => 'fa fa-folder',
            'state' => ['opened' => true]
        ];

        $where = [new DataBaseWhere('folder', null, 'IS NOT')];
        $files = AttachedFile::all($where);

        // Control de duplicados
        $addedFolders = [];

        foreach ($files as $file) {
            $parentId = 'root';

            if ($file->folder) {
                $parts = explode('/', trim($file->folder, '/'));
                $currentPath = '';

                foreach ($parts as $part) {
                    $currentPath .= '/' . $part;
                    $folderId = 'folder-' . md5($currentPath);

                    if (!in_array($folderId, $addedFolders, true)) {
                        $nodes[] = [
                            'id' => $folderId,
                            'parent' => $parentId,
                            'text' => $part,
                            'icon' => 'fa fa-folder'
                        ];
                        $addedFolders[] = $folderId;
                    }

                    $parentId = $folderId; // siguiente nivel
                }
            }

            // Añadir nodo archivo
            $nodes[] = [
                'id' => 'file-' . $file->idfile,
                'parent' => $parentId,
                'text' => $file->filename,
                'icon' => 'fa fa-file',
                'a_attr' => [
                    'data-url' => $file->url('download-permanent'),
                    'data-ext' => $file->getExtension()
                ]
            ];
        }

        return $nodes;
    }

    public function uploadFile()
    {
        if (empty($_FILES['file']['tmp_name'])) {
            return; // No hay archivo
        }

        $folder = trim($_POST['folder'] ?? '', '/');

        $file = new AttachedFile();
        $file->filename = $_FILES['file']['name'];
        $file->folder = $folder;

        $targetPath = 'path/to/uploads/' . $file->filename;
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $file->path = $targetPath; // o lo que uses para el campo en DB
        $file->save();
    }
}
