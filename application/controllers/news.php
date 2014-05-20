<?php
class News extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('news_model');
    $this->load->helper('url');
     $this->load->helper('form');
    $this->load->library('javascript');
    $this->load->library('session');
  }
  
  
  	function do_upload()
	{
		$config['upload_path'] = './pic';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = true;
		$this->load->helper('file');
		$this->load->library('upload',$config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			var_dump( $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$filename = $data["upload_data"]['file_name'];
			$del = $this->news_model->update_pic($filename);
			if($del != "Anonymous.png")
				@unlink("./pic/$del");
			$this->session->set_userdata('user_image',$filename);
			redirect('/news/profile', 'location', 301);
		}
	}
	
  public function del_post($id)
  {
	  $this->news_model->del_post($id);
		echo "DONE!";
  }
  
  
  public function logout()
  {
	  $this->session->sess_destroy();
	  redirect('/news/profile', 'location', 301);
  }
  
	public function profile($id = false)
	{
		$user = $this->session->userdata('username');
		if($user)
		{
			$data = array();
			$data['title'] = "Profile";
			$user = $this->session->userdata('username');
			if($id)
			{
				$data['records'] = $this->news_model->get_record(0,$id);
				$result = $this->news_model->get_user(0,$id);
			}
			else
			{
				$result = $this->news_model->get_user(0,$this->session->userdata('user_id'));
				$data['records'] = $this->news_model->get_record(0,$this->session->userdata('user_id'));
			}

			$data['name'] = $result->name;
			$data['photo'] = $result->image;
			$data['error'] = '';
			$this->load->view('templates/header', $data);
			$this->load->view('news/profile', $data);
			$this->load->view('templates/footer');
			
		}
		else
		{
			redirect('/news/login', 'location', 301);
		}
	
		
	}

  public function login()
  {
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('account', '帳號', 'trim|required|min_length[3]|max_length[50]|xss_clean|alpha_dash');
    $this->form_validation->set_rules('password', '密碼', 'trim|required|md5|alpha_dash');
	$data = array();
	$data['title'] = "login";
	
	$result = $this->news_model->get_user($this->input->post('account'));	
	
	if ($this->form_validation->run() )
	{

		if($result->password != $this->input->post('password'))
		{
			echo "wrong password!";
			$this->load->view('news/login', $data);
		}
		else
		{
			$this->session->set_userdata('username',$result->name);
			$this->session->set_userdata('user_id',$result->id);
			$this->session->set_userdata('user_image',$result->image);
			echo $this->session->userdata('username');
			redirect('/news/profile', 'location', 301);
		}
	}
	else
	{
		$this->load->view('news/login', $data);
	}

  }

  public function validate()
  {
	  $this->load->library('securimage/securimage');
    $img = new Securimage();

	  if($img->check( $this->input->post('captcha')))
	  {
		  die(json_encode(array('status' => 'success', 'message' => 'QQ')));
		}else
		{
			die(json_encode(array('status' => 'fail', 'message' => $img->getCode())));
		}


  }

  public function index()
  {

    $data['title'] = 'Timeline';
	$this->load->helper('form');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('comment', '內文', 'xss_clean|trim');
    $this->load->helper('html');
  
	    $this->load->view('templates/header', $data);

    $records = $this->news_model->get_record();
	foreach ($records as $record_item)
	{
		$id = $record_item['id'];
		$data['records_item'] = $this->news_model->get_record($id);
		$data['fields'] = $this->news_model->get_fields($id);
		$data['num'] = $this->news_model->get_num($id);
		$data['comments'] = $this->news_model->get_comment($id);
		$data['user'] = $this->news_model->get_user(0,$data['records_item']->user_id);
		      $this->load->view('news/view', $data);
		
	}
	
	
	$this->form_validation->run();


    $this->load->view('templates/footer');
  }
  public function add_comment()
  {
	   $this->news_model->add_comment();
  }
  
   public function view($id)
  {
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('comment', '內文', 'required|xss_clean|trim');
    $this->load->helper('html');
		     $this->load->library('securimage/securimage');


    $data['records_item'] = $this->news_model->get_record($id);
    $data['fields'] = $this->news_model->get_fields($id);
    $data['num'] = $this->news_model->get_num($id);
    $data['comments'] = $this->news_model->get_comment($id);
    $data['user'] = $this->news_model->get_user(0,$data['records_item']->user_id);

    if (empty($data['records_item']))
    {
      show_404();
    }

    $data['title'] = $data['records_item']->date;

    if ($this->form_validation->run() === FALSE)
    {
      $this->load->view('templates/header',   $data);

      $this->load->view('news/view', $data);

      $this->load->view('templates/footer');
    }
    
  }


  public function cap()
  {
	     $this->load->library('securimage/securimage');
    $img = new Securimage();
    $img->image_width = 125;
    $img->image_height = 40;
    $img->perturbation = 0.3;
    $img->image_bg_color = new Securimage_Color("#000000");
   $img->use_transparent_text = true;
   $img->text_transparency_percentage = 0; // 100 為全透明
   $img->text_color = new Securimage_Color("#ffffff");
    $img->num_lines = 1;
   $img->use_wordlist = true;

   if (!empty($_GET['namespace'])) $img->setNamespace($_GET['namespace']);

     $img->show();

  }



  public function record()
  {
    $this->load->helper('form');
    $this->load->library('form_validation');
    $data['title'] = "Record Page";

    $data['sorts'] = $this->news_model->get_sort();

    foreach ($data['sorts'] as $sort) {
      $data[$sort['name']] = $this->news_model->get_sort_list($sort['name']);
    }

    $this->form_validation->set_rules('ingredients[]', '名稱', 'required');
    $this->form_validation->set_rules('title', 'TITLE', 'required');

    if ($this->form_validation->run() === FALSE)
    {
      $this->load->view('templates/header', $data);
      $this->load->view('news/record');
      $this->load->view('templates/footer');
    }
    else
    {
      $this->news_model->add_record();
      $this->load->view('news/success');
    }

  }

  public function del()
  {
    $this->load->helper('form');
    $this->load->library('form_validation');
    $data['title'] = "Delete Page";

    $data['sorts'] = $this->news_model->get_sort();

    foreach ($data['sorts'] as $sort) {
      $data[$sort['name']] = $this->news_model->get_sort_list($sort['name']);
    }

    $this->form_validation->set_rules('sort', '種類', 'required');
    $this->form_validation->set_rules('name', '名稱', 'required');

    if ($this->form_validation->run() === FALSE)
    {
      $this->load->view('templates/header', $data);
      $this->load->view('news/delete');
      $this->load->view('templates/footer');
    }
    else
    {
      $this->news_model->del_news();
      $this->load->view('news/success');
    }

  }

  public function add()
  {
    $this->load->helper('form');
    $this->load->library('form_validation');
    $data['title'] = 'Create a news Training List';

    $data['sorts'] = $this->news_model->get_sort();

    $this->form_validation->set_rules('sort', '種類', 'required');
    $this->form_validation->set_rules('name', '名稱', 'required');

    if ($this->form_validation->run() === FALSE)
    {
      $this->load->view('templates/header', $data);
      $this->load->view('news/create');
      $this->load->view('templates/footer');
    }
    else
    {
      $this->news_model->set_news();
      $this->load->view('news/success');
    }

  }


}
?>
