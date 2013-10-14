<?php

class HomeController extends BaseController {
    

    public function getIndex()
    {
        return View::make('search');
    }

    
	public function getSearch()
	{
		return View::make('search');
	}

}