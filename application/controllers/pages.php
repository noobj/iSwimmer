<?php
class Pages extends CI_Controller{

  public function view($page = 'home')
  {
    if ( ! file_exists('application/views/pages/'.$page.'.php'))
    {
    }

    $data['title'] = ucfirst($page); // 第一個字母大寫

    $this->load->view('templates/header', $data);
    $this->load->view('pages/'.$page, $data);
    $this->load->view('templates/footer', $data);


    $this->load->model('member');
    $result = Member::all();
    echo "<pre>";
    print_r ($result);
    echo "</pre>";


  }
}
?>
