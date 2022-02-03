<?php 

namespace HSP\View;

class Api_Panel extends \WPSEED\View 
{
    public function __construct($args)
    {
        parent::__construct($args, [
            
            'branches' => []
        ]);

        $this->setBranches();

        $this->setArgsToProps(true);
    }

    protected function setBranches()
    {
        if(!$this->args['branches'])
        {
            $terms = get_terms([
                'taxonomy' => 'branch',
                'hide_empty' => false
            ]);

            if(!is_wp_error($terms))
            {
                foreach($terms as $term)
                {
                    $this->args['branches'][] = [
                        'id' => $term->term_id,
                        'slug' => $term->slug,
                        'name' => $term->name
                    ];
                }
            }
        }
    }
}