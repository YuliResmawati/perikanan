<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dynamic_Menu {
	/**
	* Dynamic Menu Result
	*
    */
    public $result = '';

    /**
	* Dynamic Menu Default Template Name
	*
    */
    protected $template_name = 'cidm_default';

    /**
	* Constructor
	*
	* @access	public
	*
    */
      
    public function __construct()
    {	
        $this->ci =& get_instance();
        $this->ci->load->config('dynamic_menu');
        $this->db_model = $this->ci->config->item('db_model');
        $this->db_function = $this->ci->config->item('db_function');
        $this->session_level_name = $this->ci->config->item('session_level_name');

        $this->set_config($this->template_name);
    }

    // --------------------------------------------------------------------

    /**
    * Load_Config
    *
    * @access	public
    * @param	string $config
    * @return	void
    */	

    function set_config($config){
        
        $this->db_menu_type = $this->ci->config->item('db_menu_type', $config);
        $this->menu_icon_class = $this->ci->config->item('menu_icon_class', $config);
        $this->menu_anchor_class = $this->ci->config->item('menu_anchor_class', $config);
        $this->menu_label_tag_open = $this->ci->config->item('menu_label_tag_open', $config);
        $this->menu_label_tag_close = $this->ci->config->item('menu_label_tag_close', $config);
        $this->menu_child_icon_class = $this->ci->config->item('menu_child_icon_class', $config);
        $this->menu_child_anchor_class = $this->ci->config->item('menu_child_anchor_class', $config);
        $this->menu_child_label_tag_open = $this->ci->config->item('menu_child_label_tag_open', $config);
        $this->menu_child_label_tag_close = $this->ci->config->item('menu_child_label_tag_close', $config);
        $this->menu_parent_class = $this->ci->config->item('menu_parent_class', $config);
        $this->menu_parent_anchor_attribute = $this->ci->config->item('menu_parent_anchor_attribute', $config);
        $this->menu_parent_ul_class = $this->ci->config->item('menu_parent_ul_class', $config);
        $this->menu_parent_arrow_icon = $this->ci->config->item('menu_parent_arrow_icon', $config);
        $this->menu_parent_arrow_position = $this->ci->config->item('menu_parent_arrow_position', $config);
        
        $this->generate_menu();
    }
    // --------------------------------------------------------------------

    /**
    * Generate menu list from db
    *
    * @access	private
    * @return	void
    */	
    
    function generate_menu(){
        $ci = &get_instance();
        $level = $ci->session->userdata($this->session_level_name);
        if ($level) {
            $ci->load->model($this->db_model);
            $model_function = $this->db_function;
            $menu = $ci->m_acl->$model_function($level, $this->db_menu_type);
            if(!empty($menu)) {
                foreach ($menu as $item) {
                    $item->subs = array();
                    $indexedItems[$item->id] = (object) $item;
                }
                $topLevel = array();
                foreach ($indexedItems as $item) {
                    if ($item->parent == 0) {
                        $topLevel[] = $item;
                    } else {
                        $indexedItems[$item->parent]->subs[] = $item;
                    }
                }

                $this->result = $this->render_menu($topLevel);
            }
        }
    }

    // --------------------------------------------------------------------

    /**
    * Render menu from the list
    *
    * @access	private
    * @param	array $items
	* @param	bool $parent
    * @return	string
    */

    function render_menu($items, $parent = false)
    {
        $render = '';
        $menuIndex = 1;
        foreach ($items as $item) {
            $icon = '';
            if (!empty($item->subs)) {
                if (!empty($item->icon)) {
                    $icon = '<i class='.$this->menu_icon_class.'"' . $item->icon . '"></i>';
                }

                $render .= '<li class="'.$this->menu_parent_class.'"><a class="'.$this->menu_anchor_class.'" '.$this->menu_parent_anchor_attribute.' href="#gdm_' . $menuIndex . '">'
                                . ((!empty($this->menu_parent_arrow_position) && $this->menu_parent_arrow_position=='L') ? $this->menu_parent_arrow_icon : '')
                                . $icon
                                . $this->menu_label_tag_open
                                    . $item->title
                                . $this->menu_label_tag_close
                                . ((!empty($this->menu_parent_arrow_position) && $this->menu_parent_arrow_position=='R') ? $this->menu_parent_arrow_icon : '')
                            .'</a>';
                $render .= '<ul class="'.$this->menu_parent_ul_class.'" id="gdm_' . $menuIndex . '">';
                $render .= $this->render_menu($item->subs, true);
                $render .= '</ul>';
                $render .= '</li>';
            } else {
                if($parent == true) {
                    if (!empty($item->icon)) {
                        $icon = '<i class='.$this->menu_child_icon_class.'"' . $item->icon . '"></i>';
                    }

                    $render .= '<li><a class="'.$this->menu_child_anchor_class.'" href="' . base_url($item->url) . '">'
                                    . $icon 
                                    . $this->menu_child_label_tag_open 
                                        . $item->title 
                                    . $this->menu_child_label_tag_close
                                .'</a></li>';
                }else{
                    if (!empty($item->icon)) {
                        $icon = '<i class='.$this->menu_icon_class.'"' . $item->icon . '"></i>';
                    }

                    $render .= '<li><a class="'.$this->menu_anchor_class.'" href="' . base_url($item->url) . '">'
                                    . $icon 
                                    . $this->menu_label_tag_open 
                                        . $item->title 
                                    . $this->menu_label_tag_close
                                .'</a></li>';
                }
                
            }
            $menuIndex++;
        }

        return $render;
    }

}
// END DynamicMenu Class
/* End of file DynamicMenu.php */
/* Location: ./application/libraries/DynamicMenu.php */
