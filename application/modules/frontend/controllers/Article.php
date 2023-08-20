<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'artikel';
		$this->load->model('m_article');
        $this->load->library('img');
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{
        if (current_url() == base_url('artikel/page')) {
			redirect('artikel', 'refresh');
		}

        $per_page = 8;
		$offset = 0;
		$result_count = count($this->m_article->where(['status' => '1'])->findAll());
		$config = $this->paging;
		$config['base_url'] 	    = site_url('artikel/page');
		$config['total_rows'] 	    = $result_count;
		$config['per_page'] 	    = $per_page;
		$config['use_page_numbers'] = TRUE;

		$img_config['base_path'] = $this->data['image_path'] .'article';
		$img_config['base_url'] = $this->data['file_image_path'] .'article';
		$img_config['sharpen'] = TRUE;

		if ($config['use_page_numbers'] == TRUE) {
			$page = $this->uri->segment(3) - 1;
			if ($page > 0) {
				$offset = $page * $per_page;
			}
		} else {
			$offset = $this->uri->segment(3);
		}

		$this->pagination->initialize($config);

        $this->data['page_title'] = "Artikel";
        $this->data['page_description'] = "Kumpulan artikel silat pendidikan kota bukittinggi.";
		$this->data['article'] = $this->m_article->get_content_article($per_page, '', $offset);
		$this->data['popular_article'] = $this->m_article->get_related_article(3);

		if ($result_count > $per_page) {
			$this->data['status_paging'] = 'show';
		} else {
			$this->data['status_paging'] = 'hidden';
		}

        $this->data['config'] = $img_config;
        
		$this->load->view('article/v_index', $this->data);
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
