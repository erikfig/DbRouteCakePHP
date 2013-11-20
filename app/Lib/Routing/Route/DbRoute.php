<?php

App::uses('ClassRegistry', 'Utility');

class DbRoute extends CakeRoute
{
	
	protected function returnSlug($slug)
	{
		if (empty($slug)) {
			return '/';
		}
		
		return $slug;
	}
	
	protected function getPass($slug)
	{
		if (preg_match('/^(\/).{1,}/',$slug)) {
			$slug = substr($slug,1);
		}
		if (preg_match('/.{1,}(\/)$/',$slug)) {
			$slug = substr($slug,0,-1);
		}
		return explode('/',$slug);
		
	}
	
	public function parse($slug)
	{
		$slug = $this->returnSlug($slug);
		$route = ClassRegistry::init('Route');
		$url=$route->find('first',array('conditions'=>array('Route.slug'=>$slug)));
		
		if(empty($url)) {
			return false;
		} else {
			$parse['controller']=$url['Route']['controller'];
			$parse['action']=$url['Route']['action'];
			$parse['pass']=$this->getPass($url['Route']['pass']);
			if (empty($parse['pass'])) {
				unset($parse['pass']);
			}
			return $parse;
		}
		
	}
}