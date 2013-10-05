<?php

class HomeController extends BaseController {
    

    public function getIndex()
    {
        return View::make('hello');
    }

    
	public function getSearch()
	{
		return View::make('search');
	}

}