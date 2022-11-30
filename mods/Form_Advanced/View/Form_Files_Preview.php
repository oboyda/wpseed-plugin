<?php

namespace PBOOT\Mod\Form_Advanced\View;

class Form_Files_Preview extends \PBOOT\View\View 
{
    public function __construct($args)
    {
        parent::__construct($args, [
            'attachment_ids' => [],
            'cols' => 3,
            'preview_size' => 'thumbnail',
            'preview_rel_class' => 'rect-150-100',
            'del_input_name' => '',
            'file_type' => 'image',
            'items_html' => []
        ]);

        $this->setItemsHtml();
    }

    protected function setItemsHtml()
    {
        if(empty($this->args['items_html']) && $this->args['attachment_ids'])
        {
            foreach($this->args['attachment_ids'] as $i => $attachment_id)
            {
                $item_html  = '<div class="file-item file-' . $this->args['file_type'] . '">';
                    if($this->args['file_type'] == 'image')
                    {
                        $item_html .= $this->getImageHtml($attachment_id, ['size' => $this->args['preview_size'], 'rel_class' => $this->args['preview_rel_class']]);
                    }
                    if($this->args['del_input_name'])
                    {
                        $item_html .= '<input id="' . $this->args['del_input_name'] . '_' . $i . '" type="checkbox" name="' . $this->args['del_input_name'] . '[]" value="' . $attachment_id . '" />';
                        $item_html .= '<label for="' . $this->args['del_input_name'] . '_' . $i . '" class="file-del bi-before"></label>';
                    }
                $item_html .= '</div>';

                $this->args['items_html'][] = $item_html;
            }
        }
    }
}
