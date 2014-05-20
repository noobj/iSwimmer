<?php
class News_model extends CI_Model{

  public function __construct()
  {
    $this->load->database();
  }
  
  public function update_pic($file)
  {
	$id = $this->session->userdata('user_id');
		$this->db->where('id',$id);
	$query = $this->db->get('user');
	$result = $query->row();
	$data = array(
		'image' => $file
		);
	$this->db->where('id',$id);
	$this->db->update('user',$data);
	return $result->image;
	
	  
   }
  
  public function del_post($id)
  {
	  $this->db->where('list_id', $id);
	  $this->db->delete('list_comment'); 
	  $this->db->where('id', $id);
	  $this->db->delete('training_record'); 
  }

  public function get_user($account = false,$id = false)
  {
	  if($id)
	  {
		  $query = $this->db->get_where('user',array('id'=>$id));
		return $query->row();
	  }else
	  {
			$query = $this->db->get_where('user',array('account'=>$account));
			return $query->row();
		}
   }
   
  public function get_record($id = FALSE,$userid = FALSE,$num = false,$offset = false)
  {
	    $this->db->order_by("date","desc");
		if($userid)
		{
		  $query = $this->db->get_where('training_record', array('user_id' => $userid));
			return $query->result_array();
		}elseif($id)
		{
			$query = $this->db->get_where('training_record', array('id' => $id));
			return $query->row();
		}elseif($num && $offset)
		{
			$query = $this->db->get('training_record',$num,$offset);
			return $query->result_array();		
		}else
		{
			$query = $this->db->get('training_record');
			return $query->result_array();	
		}
  }

  public function get_num($id = FALSE)
  {
    if ($id === FALSE)
    {
      return;
    }

    $query = $this->db->get_where('training_record', array('id' => $id));
    return $query->num_fields();
  }


  public function get_fields($id = FALSE)
  {
    if ($id === FALSE)
    {
      return;
    }

    $query = $this->db->get_where('training_record', array('id' => $id));
    return $query->list_fields();
  }




  public function get_news($slug = FALSE)
  {
    if ($slug === FALSE)
    {
      $query = $this->db->get('news');
      return $query->result_array();
    }

    $query = $this->db->get_where('news', array('slug' => $slug));
    return $query->row_array();
  }

  public function get_sort()
  {
      $query = $this->db->get('training_sort');
      return $query->result_array();
  }

  public function get_sort_list($sort)
  {
    $this->db->where('sort',$sort);
    $query = $this->db->get('training_list');
    return $query->result_array();
  }

  public function set_news()
  {

    $data = array(
      'sort' => $this->input->post('sort'),
      'name' => $this->input->post('name')
    );

    $this->db->insert('training_list', $data);
    $addname = $this->input->post('sort')."_".$this->input->post('name');
    $sql = "ALTER TABLE `training_record` ADD $addname INT NULL DEFAULT NULL";
    return $this->db->query($sql);
  }


  public function del_news()
  {

    $data = array(
      'sort' => $this->input->post('sort'),
      'name' => $this->input->post('name')
    );

    $this->db->where($data);
    $this->db->delete('training_list');
    $addname = $this->input->post('sort')."_".$this->input->post('name');
    $sql = "ALTER TABLE `training_record` DROP COLUMN $addname";
    return $this->db->query($sql);
  }


  public function add_record()
  {
    $data = array(
      'title' => $this->input->post('title'),
      'user_id' => $this->session->userdata('user_id'),
      'name' => $this->session->userdata('username')
    );
    $a = $this->input->post('ingredients');
    foreach ($a as $row)
    {
      $query = $this->db->get_where('training_list',array('id' => $row));
      foreach($query->result() as $i)
      {
        $j =  $i->sort."_".$i->name;
        $data[$j] = 1;
      }
    }
    $this->db->insert('training_record',$data);
  }

  public function add_comment()
  {
    $data = array(
      'list_id' => $this->input->post('list_id'),
      'content' => $this->input->post('comment'),
      'user_id' => $this->session->userdata('user_id'),
      'user_name' => $this->session->userdata('username'),
      'user_image' => $this->session->userdata('user_image')
    );

    $this->db->insert('list_comment', $data);
  }

  public function get_comment($id = false)
  {
    $query = $this->db->get_where('list_comment',array('list_id' => $id ));
    return $query->result_array();
  }

}
?>
