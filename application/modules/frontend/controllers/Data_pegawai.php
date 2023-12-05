<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_pegawai extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'data_pegawai';
		$this->load->model('m_pegawai');
        // $this->load->library('img');
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{
        

        $this->data['page_title'] = "Kepegawaian";
        $this->data['page_description'] = "Kepegawaian Dinas Ketahanan Pangan dan Perikanan.";
		$this->db->order_by('eselon_id', 'ASC');
		$this->data['pegawai'] = $this->m_pegawai->get_pegawai()->findAll();
        
		$this->load->view('pegawai/v_index', $this->data);
    }

	public function detail($slug)
    {
        $article_detail = $this->m_article->get_article_by_slug($slug);

		if ($article_detail) {
			$this->data['page_title'] = $article_detail->title;
			$this->data['page_description'] = cut_character_datatables($article_detail->description, 200);
			$this->data['page_image'] = str_files_images('article/', $article_detail->image, true, true);
			$this->data['detail_article'] = $article_detail;
			$this->data['popular_article'] = $this->m_article->get_related_article(3, $article_detail->id);

			$this->load->view('article/v_detail', $this->data);
		} else {
			show_404();
		}
    }

}

/* End of file Article.php */
