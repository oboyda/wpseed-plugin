<?php

namespace PBOOT\Mod\Form_Advanced\View;

class Form_Files_Preview extends \PBOOT\View\View 
{
    const MOD_NAME = 'Form_Advanced';

    public function __construct($args)
    {
        parent::__construct($args, [
            'attachment_ids' => [],
            'cols' => 3,
            'preview_size' => 'thumbnail',
            'preview_rel_class' => 'rect-150-100',
            'del_input_name' => '',
            'feat_input_name' => '',
            'feat_input_selected' => '',
            'order_input_name' => '',
            'file_type' => 'image'
            // 'items_html' => []
        ]);

        // $this->setItemsHtml();
        $this->_setHtmlClass();
    }

    // protected function setItemsHtml()
    // {
    //     if(empty($this->args['items_html']) && $this->args['attachment_ids'])
    //     {
    //         foreach($this->args['attachment_ids'] as $i => $attachment_id)
    //         {
    //             $item_html  = '<div class="file-item file-' . $this->args['file_type'] . '">';
    //                 $item_html .= '<div class="item-inner">';
    //                     if($this->args['file_type'] == 'image')
    //                     {
    //                         $item_html .= $this->getImageHtml($attachment_id, ['size' => $this->args['preview_size'], 'rel_class' => $this->args['preview_rel_class']]);
    //                     }
    //                     $item_html .= '<div class="action-inputs">';
    //                         if($this->args['feat_input_name'])
    //                         {
    //                             $checked = ($this->args['feat_input_selected'] === $attachment_id) ? ' checked' : '';
    //                             $item_html .= '<div class="action-input feat-input">';
    //                                 $item_html .= '<input id="' . $this->args['feat_input_name'] . '_' . $i . '" type="radio" name="' . $this->args['feat_input_name'] . '" value="' . $attachment_id . '"' . $checked . ' />';
    //                                 $item_html .= '<label for="' . $this->args['feat_input_name'] . '_' . $i . '"><i class="bi bi-check-circle-fill"></i></label>';
    //                             $item_html .= '</div>';
    //                         }
    //                         if($this->args['del_input_name'])
    //                         {
    //                             $checked = (is_array($this->args['feat_input_selected']) && in_array($attachment_id, $this->args['feat_input_selected'])) ? ' checked' : '';
    //                             $item_html .= '<div class="action-input del-input">';
    //                                 $item_html .= '<input id="' . $this->args['del_input_name'] . '_' . $i . '" type="checkbox" name="' . $this->args['del_input_name'] . '[]" value="' . $attachment_id . '"' . $checked . ' />';
    //                                 $item_html .= '<label for="' . $this->args['del_input_name'] . '_' . $i . '"><i class="bi bi-trash-fill"></i></label>';
    //                             $item_html .= '</div>';
    //                         }
    //                     $item_html .= '</div>';
    //                 $item_html .= '</div>';
    //             $item_html .= '</div>';

    //             $this->args['items_html'][] = $item_html;
    //         }
    //     }
    // }

    protected function _setHtmlClass()
    {
        $this->addHtmlClass('cols-num-' . $this->args['cols']);

        if($this->isSortable())
        {
            $this->addHtmlClass('is-sortable');
        }
    }

    public function isSortable()
    {
        return ($this->args['order_input_name'] && count($this->args['attachment_ids']) > 1);
    }
}