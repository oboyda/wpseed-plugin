<?php

namespace PBOOT\View;

class List_Pager extends View
{
    public function __construct($args)
    {
        parent::__construct($args, [
            
            'paged' => 1,
            'items_total' => 0,
            'items_per_page' => 10,
            'pages_visible' => 10
        ]);

        $this->setPageChunks();
    }

    protected function setPageChunks()
    {
        $this->args['pages_max'] = ceil($this->args['items_total'] / $this->args['items_per_page']);

        $pages = [];
        for($p=1; $p<=$this->args['pages_max']; $p++)
        {
            $pages[] = $p;
        }

        $this->args['page_chunks'] = array_chunk($pages, $this->args['pages_visible']);
        $this->args['page_chunks_num'] = count($this->args['page_chunks']);

        $this->args['page_prev'] = ($this->args['paged'] > 0) ? $this->args['paged'] - 1 : 1;
        $this->args['page_next'] = ($this->args['paged'] < $this->args['pages_max']) ? $this->args['paged'] + 1 : $this->args['pages_max'];
    }
}
