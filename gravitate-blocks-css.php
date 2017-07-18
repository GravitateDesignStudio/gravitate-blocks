<?php

/**
 *
 * @author Gravitate
 *
 */
class GRAV_BLOCKS_CSS {

	public $class = array();


	/**
	 * This is the initial setup that connects the Settings and loads the Fields from ACF
	 *
	 * @return void
	 */
	public function __construct()
	{
		//return $this->class;
	}

	public function css()
	{
		return $this;
	}

	/**
	 * Runs on WP init
	 *
	 * @return void
	 */
	public function col($small=null, $med=null, $large=null, $xlarge=null)
	{
		$this->class[] = 'columns';

		if(is_numeric($small))
		{
			$this->class[] = 'col-xs-'.$small;
			$this->class[] = 'small-'.$small;
		}
		else
		{
			$this->class[] = 'small-12';
		}

		if(is_numeric($med))
		{
			$this->class[] = 'col-sm-'.$med;
			$this->class[] = 'medium-'.$med;
		}

		if(is_numeric($large))
		{
			$this->class[] = 'col-md-'.$large;
			$this->class[] = 'large-'.$large;
		}

		if(is_numeric($xlarge))
		{
			$this->class[] = 'col-lg-'.$xlarge;
			$this->class[] = 'xlarge-'.$xlarge;
		}

		return $this;
	}

	public function col_offset($small=null, $med=null, $large=null, $xlarge=null)
	{
		if(is_numeric($small))
		{
			$this->class[] = 'col-xs-offset-'.$small;
			$this->class[] = 'small-offset-'.$small;
		}

		if(is_numeric($med))
		{
			$this->class[] = 'col-sm-offset-'.$med;
			$this->class[] = 'medium-offset-'.$med;
		}

		if(is_numeric($large))
		{
			$this->class[] = 'col-md-offset-'.$large;
			$this->class[] = 'large-offset-'.$large;
		}

		if(is_numeric($xlarge))
		{
			$this->class[] = 'col-lg-offset-'.$xlarge;
			$this->class[] = 'xlarge-offset-'.$xlarge;
		}

		return $this;
	}

	public function col_push($small=null, $med=null, $large=null, $xlarge=null)
	{
		if(is_numeric($small))
		{
			$this->class[] = 'col-xs-push-'.$small;
			$this->class[] = 'small-push-'.$small;
		}

		if(is_numeric($med))
		{
			$this->class[] = 'col-sm-push-'.$med;
			$this->class[] = 'medium-push-'.$med;
		}

		if(is_numeric($large))
		{
			$this->class[] = 'col-md-push-'.$large;
			$this->class[] = 'large-push-'.$large;
		}

		if(is_numeric($xlarge))
		{
			$this->class[] = 'col-lg-push-'.$xlarge;
			$this->class[] = 'xlarge-push-'.$xlarge;
		}

		return $this;
	}

	public function col_pull($small=null, $med=null, $large=null, $xlarge=null)
	{
		if(is_numeric($small))
		{
			$this->class[] = 'col-xs-pull-'.$small;
			$this->class[] = 'small-pull-'.$small;
		}

		if(is_numeric($med))
		{
			$this->class[] = 'col-sm-pull-'.$med;
			$this->class[] = 'medium-pull-'.$med;
		}

		if(is_numeric($large))
		{
			$this->class[] = 'col-md-pull-'.$large;
			$this->class[] = 'large-pull-'.$large;
		}

		if(is_numeric($xlarge))
		{
			$this->class[] = 'col-lg-pull-'.$xlarge;
			$this->class[] = 'xlarge-pull-'.$xlarge;
		}

		return $this;
	}

	public function grid($small=1, $med=2, $large=3, $xlarge=4)
	{

		if($small && $small <= 6)
		{
			$this->class[] = 'small-block-grid-'.$small;
			$this->class[] = 'small-up-'.$small;
		}

		if($med && $med <= 6)
		{
			$this->class[] = 'medium-block-grid-'.$med;
			$this->class[] = 'medium-up-'.$med;
		}

		if($large && $large <= 6)
		{
			$this->class[] = 'large-block-grid-'.$large;
			$this->class[] = 'large-up-'.$large;
		}

		if($xlarge && $xlarge <= 6)
		{
			$this->class[] = 'xlarge-block-grid-'.$xlarge;
			$this->class[] = 'xlarge-up-'.$xlarge;
		}

		return $this;
	}


	public function row()
	{
		$this->class[] = 'row';
		return $this;
	}

	public function collapsed()
	{
		$this->class[] = 'collapsed';
		return $this;
	}


	public function col_center($small=true, $medium=null, $large=null, $xlarge=null)
	{
		$sizes = array(
			array('name' => 'small', 'value' => $small),
			array('name' => 'medium', 'value' => $medium),
			array('name' => 'large', 'value' => $large),
			array('name' => 'xlarge', 'value' => $xlarge)
		);

		foreach ($sizes as $key => $size)
		{
			if($size['value'])
			{
				$this->class[] = 'center-block';
				$this->class[] = 'mx-auto';
				$this->class[] = $size['name'].'-centered';
			}
		}

		return $this;
	}

	public function col_uncenter($small=true, $medium=null, $large=null, $xlarge=null)
	{
		$sizes = array(
			array('name' => 'small', 'value' => $small),
			array('name' => 'medium', 'value' => $medium),
			array('name' => 'large', 'value' => $large),
			array('name' => 'xlarge', 'value' => $xlarge)
		);

		foreach ($sizes as $key => $size)
		{
			if($size['value'])
			{
				$this->class[] = $size['name'].'-uncentered';
			}
		}

		return $this;
	}

	public function text_align($align='center')
	{

		$this->class[] = 'text-'.$align;
		$this->class[] = 'text-xs-'.$align;

		return $this;
	}

	public function align($align='center')
	{

		$this->class[] = 'align-'.$align;
		$this->class[] = 'col-'.$align.'ed';

		return $this;
	}

	public function hide($small=null, $medium=null, $large=null, $xlarge=null)
	{
		if($small)
		{
			$this->class[] = 'hide-for-small-only';
			$this->class[] = 'hidden-xs';
		}

		if($medium)
		{
			$this->class[] = 'hide-for-medium-only';
			$this->class[] = 'hidden-sm';
		}

		if($large)
		{
			$this->class[] = 'hide-for-large-only';
			$this->class[] = 'hidden-md';
		}

		if($xlarge)
		{
			$this->class[] = 'hide-for-xlarge';
			$this->class[] = 'hidden-lg';
		}

		return $this;
	}

	public function add($classes){
		$classes = (!is_array($classes)) ? explode(',', str_replace(' ', '', trim($classes))) : $classes;
		foreach($classes as $class){
			$this->class[] = $class;
		}

		return $this;
	}


	public function get()
	{
		$blocks_name = GRAV_BLOCKS::$current_block_name;
		$classes = $this->class;
		$classes = apply_filters('grav_get_css', $classes, $blocks_name);
		return implode(' ', array_unique($classes));
	}


	public function out()
	{
		echo $this->get();
	}
}
