<?php
//表情的替换缓存
class expression_replace_array_auto_cache extends auto_cache{
	public function load($param)
	{
		$key = $this->build_key(__CLASS__,$param);
		$GLOBALS['cache']->set_dir(APP_ROOT_PATH."public/runtime/data/".__CLASS__."/");
		$expression_replace_array = $GLOBALS['cache']->get($key);
		if($expression_replace_array===false)
		{
			$search = array();
			$replace = array();
			$result = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."expression");
			foreach($result as $item)
			{
				$search[] = $item['emotion'];
				$domain = app_conf("PUBLIC_DOMAIN_ROOT")==''?SITE_DOMAIN.$GLOBALS['IMG_APP_ROOT']:app_conf("PUBLIC_DOMAIN_ROOT");	
				$replace[] = "<img src='".$domain."/public/expression/".$item['type']."/".$item['filename']."' alt='".$item['title']."' />";
			}
			$expression_replace_array['search'] = $search;
			$expression_replace_array['replace'] = $replace;
			$GLOBALS['cache']->set_dir(APP_ROOT_PATH."public/runtime/data/".__CLASS__."/");
			$GLOBALS['cache']->set($key,$expression_replace_array);
		}
		return $expression_replace_array;
	}
	public function rm($param)
	{
		$key = $this->build_key(__CLASS__,$param);
		$GLOBALS['cache']->set_dir(APP_ROOT_PATH."public/runtime/data/".__CLASS__."/");
		$GLOBALS['cache']->rm($key);
	}
	public function clear_all()
	{
		$GLOBALS['cache']->set_dir(APP_ROOT_PATH."public/runtime/data/".__CLASS__."/");
		$GLOBALS['cache']->clear();
	}
}
?>