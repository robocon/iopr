<?php 
/**
* 
*/
class Blog
{
	public $fb_tag = array();
	function __construct()
	{
		$file = $_GET['file'];
		$this->$file();
	}

	public function readblog(){
		$db = New DB();
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);

		$id = intval($_GET['id']);

		$query = $db->select_query(sprintf("SELECT * FROM web_blog WHERE `id` = %d", $id));
		$item = $db->fetch($query);

		$title = str_replace(array('"', "'", '`'), '', $item['topic']);
		$this->fb_tag['title'] = $title;

		$headline = str_replace(array('"', "'", '`'), '', strip_tags($item['headline']));
		$this->fb_tag['description'] = $headline;
		
		$domain = $this->domain();
		$this->fb_tag['picture'] = $domain.'/icon/blog_'.$item['post_date'].'_'.$item['posted'].'.jpg';
	
		$this->fb_tag['domain'] = $domain;
	}

	public function domain(){
		return (strtolower(getenv('HTTPS')) == 'on' ? 'https' : 'http') . '://'
		. getenv('HTTP_HOST') . (($p = getenv('SERVER_PORT')) != 80 AND $p != 443 ? ":$p" : '');
	}
}
?>