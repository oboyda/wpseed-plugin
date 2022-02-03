<?php 

namespace HSP\Action;

use HSP\Api_Import as Import;
use WPSEED\Req;

class Api_Import 
{
    public function __construct()
    {
        add_action('wp_ajax_hsp_api_import', __CLASS__ . '::importProperties');
    }

    static function importProperties()
    {
        $req = new Req();
        
        $branch_id = $req->get('branch_id', 'integer');
        $page = $req->get('page', 'integer', 1);
        $per_page = $req->get('per_page', 'integer', 10);
        $session_id = $req->get('session_id');

        $import= new Import($branch_id, [
            'page' => $page,
            'per_page' => $per_page,
            'session_id' => $session_id
        ]);

        $import->importProperties();

        $res = [
            'status' =>'ok',
            'imported_refs' => $import->getImportedRefs(),
            'page_max' => $import->getPageMax(),
            'session_id' => $import->getSessionId(),
            'summary_html' => '<p>' . sprintf(__('Importing page: %d/%d', 'hsp'), $page, $import->getPageMax()) . '</p>'
        ];

        wp_send_json($res);
    }
}